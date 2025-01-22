<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\TaskLabel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = [
            [
                'title'       => 'Galvenās lapas dizaina prototipa izveide',
                'description' => 'Izveidot augstas kvalitātes dizaina prototipu galvenajai lapai, iekļaujot navigāciju, hero section, galveno piedāvājumu un aicinājumu uz darbību (CTA) pogas. Pārliecināties, ka dizains ir saskaņots ar uzņēmuma vizuālo identitāti un ir lietotājam draudzīgs.',
            ],
            [
                'title'       => 'Mobilā dizaina pielāgošana',
                'description' => 'Pielāgot galvenās lapas dizainu mobilajām ierīcēm, nodrošinot optimizētu lietotāja pieredzi uz viedtālruņiem un planšetdatoriem. Iekļaut responsīvās dizaina tehnoloģijas, piemēram, elastīgus tīklus un izmēru maiņas elementus.',
            ],
            [
                'title'       => 'Produktu specifikācijas dokumenta izveide',
                'description' => 'Sagatavot detalizētu produkta specifikāciju, iekļaujot funkcionalitātes prasības, lietošanas gadījumus, iespējamos tehniskos ierobežojumus un aprakstus par nepieciešamajiem datiem. Šis dokuments kalpos kā ceļvedis izstrādes komandai.',
            ],
            [
                'title'       => 'Lietotāju apmācības rokasgrāmatas izstrāde',
                'description' => 'Izveidot rokasgrāmatu uzņēmuma darbiniekiem, lai viņi varētu viegli apgūt sistēmas lietošanu. Šajā rokasgrāmatā jāiekļauj soļi, kā veikt ikdienas uzdevumus sistēmā, piemēram, pievienot, rediģēt un dzēst uzdevumus.',
            ],
            [
                'title'       => 'Backend: Lietotāju autentifikācijas sistēmas izstrāde',
                'description' => 'Izveidot backend funkcionalitāti, kas ļauj lietotājiem reģistrēties un pieslēgties, izmantojot e-pasta adresi un paroli. Nodrošināt JWT tokenu ģenerēšanu un apstrādi, lai lietotāji varētu autentificēties un saglabāt sesijas.',
            ],
            [
                'title'       => 'Backend: Uzdevumu API izstrāde',
                'description' => 'Izstrādāt RESTful API, kas ļauj izveidot, rediģēt un dzēst uzdevumus. API jāietver iespēja pievienot komentārus, mainīt uzdevumu statusus un filtrēt uzdevumus pēc termiņiem vai prioritātes.',
            ],
            [
                'title'       => 'Frontend: Uzdevumu saraksta un filtrēšanas izstrāde',
                'description' => 'Izveidot frontend komponenti, kas attēlo uzdevumus sarakstā ar iespējām filtrēt pēc dažādiem kritērijiem, piemēram, termiņa, statusa un prioritātes. Pārliecināties, ka saraksts ir dinamisks un atjaunojas, pievienojot vai rediģējot uzdevumus.',
            ],
            [
                'title'       => 'Frontend: Uzdevuma pievienošanas forma',
                'description' => 'Izveidot formu frontendā, kas ļauj lietotājiem pievienot jaunu uzdevumu. Forma jāietver laukus, piemēram, uzdevuma nosaukums, apraksts, termiņš un prioritāte, kā arī validācija, lai nodrošinātu visu obligāto lauku aizpildīšanu.',
            ],
            [
                'title'       => 'Frontend: Uzdevuma rediģēšanas un dzēšanas funkcionalitāte',
                'description' => 'Izstrādāt frontend funkcionalitāti, kas ļauj lietotājiem rediģēt vai dzēst esošos uzdevumus, piedāvājot interaktīvus modal logus vai apstiprinājuma uznirstošos logus, lai apstiprinātu dzēšanu.',
            ],
            [
                'title'       => 'Backend un Frontend: Uzdevuma statusa atjaunošana',
                'description' => 'Izstrādāt funkcionalitāti gan backend, gan frontend, lai lietotāji varētu atzīmēt uzdevumus kā pabeigtus vai izpildītus. Backend nodrošina statusa atjaunināšanu un datuma pievienošanu, bet frontend attēlo šo statusu lietotāja saskarnē ar skaidru vizuālu atšķirību.',
            ],
        ];

        foreach ($tasks as $data) {
            $task = Task::factory()->create($data);

            $task->labels()->sync(TaskLabel::inRandomOrder()->first()->id);
        }

        // Add an extra label to one of the tasks
        Task::inRandomOrder()->first()->labels()->sync(TaskLabel::inRandomOrder()->first()->id);
    }
}
