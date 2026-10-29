<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RegistrationController extends Controller
{
    public function index(Request $request): View
    {
        $eventId = (int) $request->query('event', 0);

        return view('admin.registrations.index', [
            'registrations' => $this->query($eventId)->get(),
            'events'        => Event::orderBy('starts_at')->get(['id', 'title']),
            'eventId'       => $eventId,
        ]);
    }

    public function destroy(Request $request, Registration $registration): RedirectResponse
    {
        $registration->delete();

        return redirect()
            ->route('admin.registrations.index', array_filter(['event' => $request->input('event')]))
            ->with('success', 'Registration removed.');
    }

    /** CSV download that opens straight in Excel. */
    public function export(Request $request): StreamedResponse
    {
        $eventId = (int) $request->query('event', 0);
        $rows = $this->query($eventId)->get();
        $filename = 'registrations' . ($eventId ? "-event{$eventId}" : '') . '.csv';

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // BOM so Excel reads UTF-8 correctly
            fputcsv($out, ['Reference', 'Event', 'Name', 'Email', 'Enrolment', 'Mobile', 'Class', 'Registered on']);
            foreach ($rows as $r) {
                fputcsv($out, [
                    $r->refCode(),
                    $r->event?->title ?? 'Removed event',
                    $r->name,
                    $r->email,
                    $r->enrollment,
                    $r->phone,
                    $r->class_name,
                    $r->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function query(int $eventId)
    {
        return Registration::with('event')
            ->when($eventId > 0, fn ($q) => $q->where('event_id', $eventId))
            ->latest();
    }
}
