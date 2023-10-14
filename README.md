# D3p0t Core
---

The D3p0t Core package serves as a base for D3p0t Modules and packages.

### Installation
Add the D3p0t Core repository to `composer.json`.
```json
    ...
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/d3p0t/core"
        }
    ],
    ...
```

Next, install the `d3p0t/core` dependency via composer

```php
composer require d3p0t/core
```

## Usage
The D3p0t Core package has a variety of logic and helper classes.

## Auth
The [Principal](src/Auth/Entities/Principal.php) class is the base Authorization entity for D3p0t.
Any entities that require authorization should extend from this class.

---

## Entities

### Model
The [Model](src/Entities/Model.php) class will automatically add an Activity log to the database.
By default, the Activity entity is filled with the `$fillable` array of an model.

This can be changed by overriding the `getActivitylogOptions` function in a model.

The Model class also provides a validation Trait.
The functions `beforeValidation` and `afterValidation` can be implemented to hook onto validation.

If Model validation should be in place, the `validateOnSaving` function should be called inside the `boot` function of the model.

```php

public static function boot() {
    parent::boot();

    static::validateOnSaving();
}
```

If you want to override when the validation takes place, you can do so in the `boot` function.

```php
public static function boot() {
    parent::boot();

    self::creating(function($model){
        $model->validate();
    });

    self::updating(function ($model) {
        $model->validate();
    });
}
```
More information about Model Validation [can be found here](https://github.com/theriddleofenigma/laravel-model-validation.)

---

## AuditableModel
The [AuditableModel](src/Entities/AuditableModel.php) class automatically fills the `created_by` and `updated_by` fields based on the logged in User. If no user is logged in, `ANONYMOUS` will be set in these columns.

Any classes extending from this model should add the following fields to their migrations:


```php

Schema::create('{TABLE}}', function (Blueprint $table) {
    ...
    $table->string('created_by')->nullable();
    $table->string('updated_by')->nullable();
});

```
## Events

### Activity Log
Custom ActivityLogs can be send as an [ActivityLog event](src/Events/ActivityLog.php). This event will be picked up by the [ActivityLogListener](src/Listeners/ActivityLogListener.php).

To enable custom ActivityLogs, you must add the ActivityLogListener to the `$listens` array in the `EventServiceProvider`.
An Activity is always performed on a Model.

```php
...
use D3p0t\Core\Events\ActivityLog;
use D3p0t\Core\Listeners\ActivityLogListener;
...

    protected $listen = [
        ...
        ActivityLog::class => [
            ActivityLogListener::class,
        ],
    ];
```

### Notification
Notifications can be sent via the [Notification Event](src/Events/Notification.php).
Notifications are always send to a [Principal](src/Auth/Entities/Principal.php). This can be a User or a System.

To enable Notifications, you must add the NotificationListener to the `$listens` array in the `EventServiceProvider`.

```php
...
use D3p0t\Core\Events\Notification;
use D3p0t\Core\Listeners\NotificationListener;
...

    protected $listen = [
        ...
        Notification::class => [
            NotificationListener::class,
        ],
    ];
```

Any Models that can receive notifications can use the [HasNotifications Trait.](src/Traits/HasNotifications.php).
This trait adds `unreadNotifications`, `readNotifications` and `sendNotification` functions.

## Pageable
To get `Paged` response, you can use the [Pageable](src/Pageable/Pageable.php) class.

Controllers can use the [PageableReqeust](src/Pageable/Requests/PageableRequest.php) and the [SortableRequest](src/Pageable/Requests/SortableRequest.php).


### Example
The example below shows the Pageable in action.

### Controller
```php

  public function search(
        PageableRequest $pageableRequest,
        SortableRequest $sortableRequest,
    ) {
        $searchCriteria = [];
        $pageable = $this->service->search(
            PageRequest::fromRequest(
                $pageableRequest,
                $sortableRequest
            ),
            $searchCriteria
        );
    }

```

#### Service
```php

public function search(PageRequest $pageRequest, array $searchCriteria = []): Pageable {
    $result = Model::where(function($q) use ($searchCriteria) {
        if (array_key_exists('name', $searchCriteria)) {
            $q->where('name', 'LIKE', '%' . $searchCriteria['name'] . '%');
        }
        // Other filters

        return $q;
    })
    ->orderBy(
        $pageRequest->sortRequest->sortBy(), $pageRequest->sortRequest->sortDirection()
    )->get();

    return new Pageable(
        $pageRequest,
        new LengthAwarePaginator(
            $result->slice(
                $pageRequest->perPage() * $pageRequest->pageNumber(),
                $pageRequest->perPage()
            ),
            $result->count(),
            $pageRequest->perPage(),
            $pageRequest->pageNumber()
        )
    );
}
```