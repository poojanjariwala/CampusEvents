<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // The only account: the admin panel login.
        User::updateOrCreate(
            ['email' => 'admin@campusevents.test'],
            ['name' => 'Event Admin', 'password' => 'admin123'] // hashed by the User model cast
        );

        // Dates are relative to today so the site always has upcoming events to show.
        $events = [
            [
                'title' => 'Web Wizards 24-Hour Hackathon',
                'category' => 'Technical',
                'starts_at' => now()->addDays(29)->setTime(9, 0),
                'venue' => 'IT Lab 3, Block B',
                'organizer' => 'IT Students Association',
                'description' => "Teams of three build a working website from scratch in 24 hours using HTML, CSS, JavaScript, PHP and Laravel. A problem statement is revealed at the start and mentors from the faculty are available throughout.\n\nJudging covers design quality, working features, code cleanliness and the final demo. Bring your own laptop and charger; snacks and tea are provided overnight.",
                'capacity' => 90,
                'fee' => 100,
            ],
            [
                'title' => 'Laravel Bootcamp: Routes to Blade',
                'category' => 'Workshop',
                'starts_at' => now()->addDays(15)->setTime(10, 0),
                'venue' => 'Seminar Hall, 1st Floor',
                'organizer' => 'Prof. R. Mehta',
                'description' => "A hands-on day covering routing, controllers, Blade templates and Eloquent basics. By the end of the session every participant will have a small CRUD application running on their own laptop.\n\nPlease install PHP 8.2+ and Composer before arriving. A setup checklist will be emailed after you register.",
                'capacity' => 60,
                'fee' => 0,
            ],
            [
                'title' => 'Rangotsav: Annual Cultural Night',
                'category' => 'Cultural',
                'starts_at' => now()->addDays(57)->setTime(17, 0),
                'venue' => 'Main Auditorium',
                'organizer' => 'Cultural Committee',
                'description' => "The department's yearly evening of dance, music, stand-up and short plays, performed by students from every batch. Seats are open to everyone.\n\nDoors open at 4:30 PM. Please carry your college ID card for entry.",
                'capacity' => 400,
                'fee' => 0,
            ],
            [
                'title' => 'Inter-Class Cricket Cup',
                'category' => 'Sports',
                'starts_at' => now()->addDays(36)->setTime(8, 0),
                'venue' => 'College Ground',
                'organizer' => 'Sports Committee',
                'description' => "Eight-over matches between every class in the department, played as a knockout. Each team needs eleven players plus two substitutes.\n\nTennis-ball cricket; kits are provided by the sports office.",
                'capacity' => 160,
                'fee' => 50,
            ],
            [
                'title' => 'Placement Readiness Seminar',
                'category' => 'Seminar',
                'starts_at' => now()->addDays(11)->setTime(11, 0),
                'venue' => 'Room 204',
                'organizer' => 'Training & Placement Cell',
                'description' => 'Two alumni working in software companies talk about resume basics, aptitude rounds and how to prepare for technical interviews in the final year. A short Q&A follows the talk.',
                'capacity' => 120,
                'fee' => 0,
            ],
            [
                'title' => 'XML & Data Exchange Quiz',
                'category' => 'Technical',
                'starts_at' => now()->addDays(21)->setTime(14, 0),
                'venue' => 'Room 101',
                'organizer' => 'Prof. S. Desai',
                'description' => "A 45-minute written quiz on XML syntax, DTD and schema, XPath, XSLT and parsing with PHP. Open to all IT-25 students and a good revision before the internal exam.\n\nTop three scorers receive certificates.",
                'capacity' => 100,
                'fee' => 0,
            ],
            [
                'title' => "Freshers' Welcome 2026",
                'category' => 'Cultural',
                'starts_at' => now()->subDays(27)->setTime(15, 0),
                'venue' => 'Main Auditorium',
                'organizer' => 'Cultural Committee',
                'description' => 'Seniors welcomed the new batch with performances, a short introduction to the department and the traditional icebreaker games.',
                'capacity' => 250,
                'fee' => 0,
            ],
        ];

        $created = [];
        foreach ($events as $data) {
            $created[] = Event::updateOrCreate(['title' => $data['title']], $data);
        }

        $people = [
            [0, 'Aarav Trivedi', 'aarav.trivedi@example.com', 'IT25A014', '9876501234', 'IT25 A (Batch A)'],
            [0, 'Meera Joshi', 'meera.joshi@example.com', 'IT25A031', '9898012345', 'IT25 A (Batch B)'],
            [1, 'Riya Patel', 'riya.patel@example.com', 'IT25B009', '9725011122', 'IT25 B (Batch A)'],
            [2, 'Kunal Shah', 'kunal.shah@example.com', 'IT25B022', '9327788990', 'IT25 B (Batch B)'],
            [3, 'Dev Solanki', 'dev.solanki@example.com', 'IT25A040', '9099123456', 'IT25 A (Batch B)'],
        ];

        foreach ($people as [$eventIndex, $name, $email, $enrollment, $phone, $class]) {
            Registration::firstOrCreate(
                ['event_id' => $created[$eventIndex]->id, 'email' => $email],
                [
                    'name' => $name,
                    'enrollment' => $enrollment,
                    'phone' => $phone,
                    'class_name' => $class,
                ]
            );
        }
    }
}
