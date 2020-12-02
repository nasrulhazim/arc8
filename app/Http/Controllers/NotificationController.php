<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = auth()->user()->notifications;

        return view('notification.index', compact('notifications'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notification = auth()->user()->notifications()->whereId($id)->firstOrFail();

        return view('notification.show', compact('notification'));
    }
}
