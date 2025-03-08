<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\TaskChecklistItem;
use App\Models\TaskComment;
use App\Models\TaskLabel;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = [
            [
                'title'       => 'Galvenās lapas dizaina prototipa izveide',
                'description' => 'Izveidot augstas kvalitātes dizaina prototipu galvenajai lapai, iekļaujot navigāciju, hero section, galveno piedāvājumu un aicinājumu uz darbību (CTA) pogas. Pārliecināties, ka dizains ir saskaņots ar uzņēmuma vizuālo identitāti un ir lietotājam draudzīgs.',
                'comments'    => [
                    ['author_id' => 3, 'body' => 'Vajadzētu apsvērt tumšo režīmu dizainā.'],
                    ['author_id' => 7, 'body' => 'CTA pogas krāsai jābūt kontrastainākai.'],
                    ['author_id' => 1, 'body' => 'Varbūt varētu pievienot animācijas, lai piesaistītu uzmanību?'],
                ],
            ],
            [
                'title'       => 'Mobilā dizaina pielāgošana',
                'description' => 'Pielāgot galvenās lapas dizainu mobilajām ierīcēm, nodrošinot optimizētu lietotāja pieredzi uz viedtālruņiem un planšetdatoriem. Iekļaut responsīvās dizaina tehnoloģijas, piemēram, elastīgus tīklus un izmēru maiņas elementus.',
                'comments'    => [
                    ['author_id' => 5, 'body' => 'Pārliecināties, ka testi tiek veikti uz dažādām ierīcēm.'],
                    ['author_id' => 8, 'body' => 'Hamburger menu jābūt intuitīvam un viegli pieejamam.'],
                ],
            ],
            [
                'title'       => 'Produktu specifikācijas dokumenta izveide',
                'description' => 'Sagatavot detalizētu produkta specifikāciju, iekļaujot funkcionalitātes prasības, lietošanas gadījumus, iespējamos tehniskos ierobežojumus un aprakstus par nepieciešamajiem datiem. Šis dokuments kalpos kā ceļvedis izstrādes komandai.',
                'comments'    => [
                    ['author_id' => 2, 'body' => 'Varbūt varētu pievienot sadaļu par drošības prasībām?'],
                    ['author_id' => 6, 'body' => 'Ļoti svarīgi iekļaut API specifikāciju, ja tāda būs.'],
                    ['author_id' => 9, 'body' => 'Lietošanas gadījumiem jābūt pēc iespējas detalizētākiem.'],
                ],
            ],
            [
                'title'       => 'Lietotāju apmācības rokasgrāmatas izstrāde',
                'description' => 'Izveidot rokasgrāmatu uzņēmuma darbiniekiem, lai viņi varētu viegli apgūt sistēmas lietošanu. Šajā rokasgrāmatā jāiekļauj soļi, kā veikt ikdienas uzdevumus sistēmā, piemēram, pievienot, rediģēt un dzēst uzdevumus.',
                'comments'    => [
                    ['author_id' => 10, 'body' => 'Būtu noderīgi pievienot ekrānšāviņus.'],
                    ['author_id' => 4, 'body' => 'Varētu būt arī video pamācības.'],
                ],
            ],
            [
                'title'       => 'Backend: Lietotāju autentifikācijas sistēmas izstrāde',
                'description' => 'Izveidot backend funkcionalitāti, kas ļauj lietotājiem reģistrēties un pieslēgties, izmantojot e-pasta adresi un paroli. Nodrošināt JWT tokenu ģenerēšanu un apstrādi, lai lietotāji varētu autentificēties un saglabāt sesijas.',
            ],
            [
                'title'       => 'Backend: Uzdevumu API izstrāde',
                'description' => 'Izstrādāt RESTful API, kas ļauj izveidot, rediģēt un dzēst uzdevumus. API jāietver iespēja pievienot komentārus, mainīt uzdevumu statusus un filtrēt uzdevumus pēc termiņiem vai prioritātes.',
                'comments'    => [
                    ['author_id' => 7, 'body' => 'API dokumentācijai jābūt skaidrai un pieejamai izstrādātājiem.'],
                    ['author_id' => 1, 'body' => 'Varbūt ir vērts pievienot GraphQL kā alternatīvu REST?'],
                ],
            ],
            [
                'title'       => 'Frontend: Uzdevumu saraksta un filtrēšanas izstrāde',
                'description' => 'Izveidot frontend komponenti, kas attēlo uzdevumus sarakstā ar iespējām filtrēt pēc dažādiem kritērijiem, piemēram, termiņa, statusa un prioritātes. Pārliecināties, ka saraksts ir dinamisks un atjaunojas, pievienojot vai rediģējot uzdevumus.',
                'comments'    => [
                    ['author_id' => 8, 'body' => 'Varētu pievienot “drag and drop” funkcionalitāti.'],
                    ['author_id' => 6, 'body' => 'Sarakstam jābūt optimizētam lielam datu apjomam.'],
                ],
            ],
            [
                'title'       => 'Frontend: Uzdevuma pievienošanas forma',
                'description' => 'Izveidot formu frontendā, kas ļauj lietotājiem pievienot jaunu uzdevumu. Forma jāietver laukus, piemēram, uzdevuma nosaukums, apraksts, termiņš un prioritāte, kā arī validācija, lai nodrošinātu visu obligāto lauku aizpildīšanu.',
                'comments'    => [
                    ['author_id' => 2, 'body' => 'Būtu noderīgi, ja lauku kļūdas tiktu parādītas tieši pie lauka.'],
                    ['author_id' => 9, 'body' => 'Vai forma būs ar auto-save funkcionalitāti?'],
                ],
            ],
            [
                'title'       => 'Frontend: Uzdevuma rediģēšanas un dzēšanas funkcionalitāte',
                'description' => 'Izstrādāt frontend funkcionalitāti, kas ļauj lietotājiem rediģēt vai dzēst esošos uzdevumus, piedāvājot interaktīvus modal logus vai apstiprinājuma uznirstošos logus, lai apstiprinātu dzēšanu.',
            ],
            [
                'title'       => 'Backend un Frontend: Uzdevuma statusa atjaunošana',
                'description' => 'Izstrādāt funkcionalitāti gan backend, gan frontend, lai lietotāji varētu atzīmēt uzdevumus kā pabeigtus vai izpildītus. Backend nodrošina statusa atjaunināšanu un datuma pievienošanu, bet frontend attēlo šo statusu lietotāja saskarnē ar skaidru vizuālu atšķirību.',
                'comments'    => [
                    ['author_id' => 5, 'body' => 'Būtu labi, ja pabeigtie uzdevumi tiktu automātiski arhivēti.'],
                    ['author_id' => 7, 'body' => 'Varbūt var pievienot dažādus statusus, piemēram, “Testēšanā” un “Atlikts”?'],
                ],
            ],
        ];

        foreach ($tasks as $data) {
            $task = Task::factory()->create([
                'title'       => $data['title'],
                'description' => $data['description']
            ]);

            $task->labels()->sync(TaskLabel::inRandomOrder()->first()->id);

            TaskChecklistItem::factory()->count(rand(2, 8))->create([
                'task_id' => $task->id
            ]);

            if (!isset($data['comments'])) {
                continue;
            }

            foreach ($data['comments'] as $comment) {
                TaskComment::create([
                    'task_id'    => $task->id,
                    'author_id'  => $comment['author_id'],
                    'body'       => $comment['body'],
                    'created_at' => now()->subMinutes(rand(1, 240))
                ]);
            }
        }

        // Add an extra label to one of the tasks
        Task::inRandomOrder()->first()->labels()->sync(TaskLabel::inRandomOrder()->first()->id);
    }
}
