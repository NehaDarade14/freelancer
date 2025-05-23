<?php

namespace Fickrr\Http\Controllers;

use Illuminate\Http\Request;
use Fickrr\Models\NotificationSetting;

use Illuminate\Support\Facades\Validator;

class NotificationSettingsController extends Controller
{
    public function update(Request $request)
    {
     
     
        $settings = NotificationSetting::getSettings(auth()->id());
        $settings->update([
            'project_updates' => $request->boolean('project_updates'),
            'messages' => $request->boolean('messages'),
            'payments' => $request->boolean('payments'),
            'new_jobs' => $request->boolean('new_jobs'),
            'application_updates' => $request->boolean('application_updates'),
        ]);

        return back()->with('success', 'Notification settings updated successfully');
    }
}