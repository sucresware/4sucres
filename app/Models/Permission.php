<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as Model;

class Permission extends Model
{
    const BYPASS_EVERYTHING  = 'bypass any guard';
    const ACCESS_ADMIN_PANEL = 'access administration panel';
    const ACCESS_MOD_PANEL   = 'access moderation panel';
    const UPDATE_SETTINGS    = 'update settings';
}
