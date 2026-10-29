<?php

namespace App\Http\Controllers;

use App\Models\Event;
use DOMDocument;
use Illuminate\Http\Response;

/**
 * Public XML feed of all events. The browser renders it as a table because the
 * document points at public/events.xsl (an XSLT stylesheet).
 */
class FeedController extends Controller
{
    public function __invoke(): Response
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;
        $dom->appendChild($dom->createProcessingInstruction(
            'xml-stylesheet',
            'type="text/xsl" href="' . asset('events.xsl') . '"'
        ));

        $root = $dom->createElement('feed');
        $root->setAttribute('generated', now()->toIso8601String());
        $root->setAttribute('base', rtrim(url('/'), '/') . '/');
        $dom->appendChild($root);

        $events = Event::withCount('registrations')->orderBy('starts_at')->get();

        foreach ($events as $event) {
            $node = $dom->createElement('event');
            $node->setAttribute('id', (string) $event->id);
            $node->setAttribute('status', $event->isPast() ? 'completed' : 'open');
            $node->setAttribute('url', route('events.show', $event));

            $fields = [
                'title'     => $event->title,
                'category'  => $event->category,
                'date'      => $event->starts_at->format('Y-m-d'),
                'time'      => $event->starts_at->format('H:i'),
                'venue'     => $event->venue,
                'organizer' => $event->organizer,
                'seats_left'=> (string) $event->seatsLeft(),
            ];
            foreach ($fields as $name => $value) {
                $child = $dom->createElement($name);
                $child->appendChild($dom->createTextNode($value));
                $node->appendChild($child);
            }

            $root->appendChild($node);
        }

        return response($dom->saveXML(), 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}
