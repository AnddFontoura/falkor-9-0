<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->greeting(__('email.hello'))
                ->subject(__('email.verify_email.verify_email_address'))
                ->line(__('email.verify_email.please_click_button_to_verify'))
                ->action(__('email.verify_email.verify_email_address'), $url)
                ->line(__('email.verify_email.if_you_didnt_create_account'))
                ->salutation(__('email.salutation'));
        });
    }
}
