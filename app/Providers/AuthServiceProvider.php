<?php

namespace App\Providers;

// use Illuminate\Support\ServiceProvider;
use App\Models\OcrdLocal;
use App\Models\OrdrLocal;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        
        // Gate::define('order.create', fn($user) => in_array($user->role, ['developer']));
        Gate::define('dashboard.refresh', function ($user) {
            return in_array($user->role, ['developer','manager', 'supervisor']);
        });
        Gate::define('order.create', function ($user) {
            return in_array($user->role, ['developer','salesman']);
        });
        Gate::define('order.push', function ($user) {
            return in_array($user->role, ['developer','supervisor']);
        });
        Gate::define('order.refresh', function ($user) {
            return in_array($user->role, ['developer','supervisor','manager']);
        });
        // Gate::define('order.push', function ($user, OrdrLocal $order) {
        //     return $user->id === $order->user_id && in_array($user->role, ['developer','salesman']);
        // });
        Gate::define('order.delete', function ($user) {
            return in_array($user->role, ['developer','salesman']);
        });
        Gate::define('report.create', function ($user) {
            return in_array($user->role, ['developer']);
        });
        Gate::define('customer.create', function ($user) {
            return in_array($user->role, ['developer','salesman']);
        });
        Gate::define('customer.edit', function ($user, OcrdLocal $cust) {
            if ($user->role === 'developer') {
                return true;
            }
            if ($user->role === 'salesman' && $user->id == $cust->created_by) {
                return true;
            }
            return false;
        });
        Gate::define('order.edit', function ($user, OrdrLocal $order) {
            // Manager bebas edit
            if ($user->role === 'developer') {
                return true;
            }
            // Salesman: cek relasi oslp_reg
            $reg = $user->oslpReg; // ambil oslp_reg dari user login
            if ($user->role === 'salesman' && $reg) {
                return $order->OdrSlpCode == $reg->RegSlpCode;
            }

            return false;
        });
        Gate::define('order.progress', function ($user, OrdrLocal $order) {
            // Manager bebas edit
            if ($user->role !== 'salesman') {
                return true;
            }
            // Salesman: cek relasi oslp_reg
            $reg = $user->oslpReg; // ambil oslp_reg dari user login
            if ($user->role === 'salesman' && $reg) {
                return $order->OdrSlpCode == $reg->RegSlpCode;
            }

            return false;
        });
        Gate::define('order.update', function ($user, OrdrLocal $order) {
            if ($user->role === 'developer') {
                return true;
            }
            $reg = $user->oslpReg;
            if ($user->role === 'salesman' && $reg) {
                return $order->OdrSlpCode == $reg->RegSlpCode;
            }
        });
        Gate::define('order.delete', function ($user, OrdrLocal $order) {
            if ($user->role === 'developer') {
                return true;
            }
            $reg = $user->oslpReg;
            if ($user->role === 'salesman' && $reg) {
                return $order->OdrSlpCode == $reg->RegSlpCode;
            }
        });
        Gate::define('user.active', function ($user) {
            if ($user->role === 'developer') {
                return true;
            }
        });
        Gate::define('user.device', function ($user) {
            if ($user->role === 'developer') {
                return true;
            }
        });
        // Gate::define('order.push', function ($user, OrdrLocal $order) {
        //     if ($user->role === 'developer') {
        //         return true;
        //     }
        //     $reg = $user->oslpReg;
        //     if ($user->role === 'salesman' && $reg) {
        //         return $order->OdrSlpCode == $reg->RegSlpCode;
        //     }
        // });
        // Gate::define('user.manage', fn($user) => $user->role === 'manager');
    }
}
