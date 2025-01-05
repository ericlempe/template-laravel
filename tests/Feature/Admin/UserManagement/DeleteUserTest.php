<?php

use App\Livewire\Admin\Users\Delete;
use App\Models\User;
use App\Notifications\UserDeletedNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertNotSoftDeleted, assertSoftDeleted};

it('should be able to delete an user', function () {
    $admin      = User::factory()->admin()->create(['name' => 'Joe Doe', 'email' => 'joe@doe.com']);
    $deleteUser = User::factory()->create();

    actingAs($admin);

    Livewire::test(Delete::class, ['user' => $deleteUser])
        ->set('confirmedDeletion', true)
        ->call('destroy')
        ->assertDispatched("user::deleted");

    assertSoftDeleted('users', [
        'id' => $deleteUser->id,
    ]);
});

it('should have a confirmation before deletion', function () {
    $admin      = User::factory()->admin()->create(['name' => 'Joe Doe', 'email' => 'joe@doe.com']);
    $deleteUser = User::factory()->create();

    actingAs($admin);

    Livewire::test(Delete::class, ['user' => $deleteUser])
        ->call('destroy')
        ->assertHasErrors(['confirmedDeletion' => 'accepted'])
        ->assertNotDispatched("user::deleted");

    assertNotSoftDeleted('users', [
        'id' => $deleteUser->id,
    ]);
});

it('should send a notification to the user telling him that he has no long access to the application', function () {
    Notification::fake();
    $admin      = User::factory()->admin()->create(['name' => 'Joe Doe', 'email' => 'joe@doe.com']);
    $deleteUser = User::factory()->create();

    actingAs($admin);

    Livewire::test(Delete::class, ['user' => $deleteUser])
        ->set('confirmedDeletion', true)
        ->call('destroy');

    Notification::assertSentTo($deleteUser, UserDeletedNotification::class);
});
