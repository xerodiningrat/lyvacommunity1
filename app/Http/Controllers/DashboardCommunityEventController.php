<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommunityEventRequest;
use App\Http\Requests\UpdateCommunityEventRequest;
use App\Models\CommunityEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardCommunityEventController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('dashboard.community-events.form', [
            'communityEvent' => new CommunityEvent([
                'event_date' => now()->toDateString(),
                'status' => 'soon',
                'sort_order' => 0,
                'is_active' => true,
            ]),
            'eventFormAction' => route('dashboard.community-events.store'),
            'eventFormMethod' => 'POST',
            'eventFormTitle' => 'Buat Event Baru',
            'eventFormSubtitle' => 'Tambah agenda baru untuk komunitas LYVA.',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommunityEventRequest $request): RedirectResponse
    {
        CommunityEvent::query()->create($this->validatedPayload($request));

        return to_route('dashboard', ['page' => 'events'])
            ->with('status', 'Event berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommunityEvent $communityEvent): View
    {
        return view('dashboard.community-events.form', [
            'communityEvent' => $communityEvent,
            'eventFormAction' => route('dashboard.community-events.update', $communityEvent),
            'eventFormMethod' => 'PUT',
            'eventFormTitle' => 'Edit Event',
            'eventFormSubtitle' => 'Perbarui agenda event yang sudah tayang di dashboard.',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommunityEventRequest $request, CommunityEvent $communityEvent): RedirectResponse
    {
        $communityEvent->update($this->validatedPayload($request));

        return to_route('dashboard', ['page' => 'events'])
            ->with('status', 'Event berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommunityEvent $communityEvent): RedirectResponse
    {
        $communityEvent->delete();

        return to_route('dashboard', ['page' => 'events'])
            ->with('status', 'Event berhasil dihapus.');
    }

    /**
     * @return array{name:string,slug:string,icon:string,event_date:string,status:string,status_label:string,status_class:string,description:string,sort_order:int,is_active:bool}
     */
    private function validatedPayload(StoreCommunityEventRequest|UpdateCommunityEventRequest $request): array
    {
        /** @var array{name:string,slug:string,icon:string,event_date:string,status:string,description:string,sort_order:int,is_active:bool} $validated */
        $validated = $request->validated();

        [$validated['status_label'], $validated['status_class']] = match ($validated['status']) {
            'live' => ['🔴 Live', 'evl'],
            'finished' => ['✓ Selesai', 'evd'],
            default => ['⏳ Soon', 'evs'],
        };

        return $validated;
    }
}
