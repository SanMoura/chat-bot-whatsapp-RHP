<?php

use Illuminate\Database\Seeder;
use App\Models\menu;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            [
                'description' => 'Copa/Nutrição',
                'icon' => 'cop',
                'active' => true,
                'refmenu' => 0,
                'order' => 1,
                'type' => 'menu',
                'grupo' => 'grp_nutricao',
                'atividade' => 'atv_nutri_servico_copa',
                'aceitar' => 'atv_nutri_servico_copa',
                'equipe' => 'eqp_nutricionistas',
            ],
            [
                'description' => 'Higienização Extra',
                'icon' => 'hig',
                'active' => true,
                'refmenu' => 0,
                'order' => 2,
                'type' => 'menu',
                'grupo' => 'grp_hig_extra',
                'atividade' => 'atv_hige_outros',
                'aceitar' => 'atv_hige_aceitar',
                'equipe' => 'eqp_higienizacao_extra',
            ],
            [
                'description' => 'Serviço Social',
                'icon' => 'enf',
                'active' => true,
                'refmenu' => 0,
                'order' => 3,
                'type' => 'menu',
                'grupo' => 'grp_servico_social',
                'atividade' => 'atv_ssc_atendimento_solic',
                'aceitar' => 'atv_ssc_aceitar',
                'equipe' => 'eqp_servico_social',
            ],
            [
                'description' => 'Lavanderia',
                'icon' => 'lav',
                'active' => true,
                'refmenu' => 0,
                'order' => 4,
                'type' => 'menu',
                'grupo' => 'grp_lavanderia',
                'atividade' => 'atv_lav_abast_roupa',
                'aceitar' => 'atv_lav_aceitar',
                'equipe' => 'eqp_lvd',
            ],
            [
                'description' => 'Psicólogos',
                'icon' => 'psi',
                'active' => true,
                'refmenu' => 0,
                'order' => 5,
                'type' => 'menu',
                'grupo' => 'grp_psicologia',
                'atividade' => 'atv_psi_atend_solic_pac',
                'aceitar' => 'atv_psi_aceitar',
                'equipe' => 'eqp_psicologos',
            ],
            [
                'description' => 'Hospitalidade',
                'icon' => 'sol',
                'active' => true,
                'refmenu' => 0,
                'order' => 6,
                'type' => 'menu',
                'grupo' => 'grp_hospitalidade',
                'atividade' => 'atv_hosp_visita_pac',
                'aceitar' => 'atv_hosp_aceitar',
                'equipe' => 'eqp_hospitalidade',
            ],

            // submenu para o grupo de copa nutricao
            [
                'description' => 'Café',
                'icon' => '',
                'active' => true,
                'refmenu' => 1,
                'order' => 1,
                'type' => 'submenu',
                'grupo' => 'grp_nutricao',
                'atividade' => 'atv_nutri_servico_copa',
                'aceitar' => 'atv_nutri_servico_copa',
                'equipe' => 'eqp_nutricionistas',
            ],
            [
                'description' => 'Lanche',
                'icon' => '',
                'active' => true,
                'refmenu' => 1,
                'order' => 2,
                'type' => 'submenu',
                'grupo' => 'grp_nutricao',
                'atividade' => 'atv_nutri_servico_copa',
                'aceitar' => 'atv_nutri_servico_copa',
                'equipe' => 'eqp_nutricionistas',
            ],
            [
                'description' => 'Falar com a Nutricionista',
                'icon' => '',
                'active' => true,
                'refmenu' => 1,
                'order' => 3,
                'type' => 'submenu',
                'grupo' => 'grp_nutricao',
                'atividade' => 'atv_nutri_servico_copa',
                'aceitar' => 'atv_nutri_servico_copa',
                'equipe' => 'eqp_nutricionistas',
            ],
            [
                'description' => 'Água',
                'icon' => '',
                'active' => true,
                'refmenu' => 1,
                'order' => 4,
                'type' => 'submenu',
                'grupo' => 'grp_nutricao',
                'atividade' => 'atv_nutri_servico_copa',
                'aceitar' => 'atv_nutri_servico_copa',
                'equipe' => 'eqp_nutricionistas',
            ],

            // submenu para o grupo de higienização

            [
                'description' => 'Solicitar Limpeza',
                'icon' => '',
                'active' => true,
                'refmenu' => 2,
                'order' => 1,
                'type' => 'submenu',
                'grupo' => 'grp_hig_extra',
                'atividade' => 'atv_hige_outros',
                'aceitar' => 'atv_hige_aceitar',
                'equipe' => 'eqp_higienizacao_extra',
            ],
            [
                'description' => 'Kit Admissão',
                'icon' => '',
                'active' => true,
                'refmenu' => 2,
                'order' => 2,
                'type' => 'submenu',
                'grupo' => 'grp_hig_extra',
                'atividade' => 'atv_hige_outros',
                'aceitar' => 'atv_hige_aceitar',
                'equipe' => 'eqp_higienizacao_extra',
            ],
            [
                'description' => 'Álcool em Gel',
                'icon' => '',
                'active' => true,
                'refmenu' => 2,
                'order' => 3,
                'type' => 'submenu',
                'grupo' => 'grp_hig_extra',
                'atividade' => 'atv_hige_outros',
                'aceitar' => 'atv_hige_aceitar',
                'equipe' => 'eqp_higienizacao_extra',
            ],
            [
                'description' => 'Sabão',
                'icon' => '',
                'active' => true,
                'refmenu' => 2,
                'order' => 4,
                'type' => 'submenu',
                'grupo' => 'grp_hig_extra',
                'atividade' => 'atv_hige_outros',
                'aceitar' => 'atv_hige_aceitar',
                'equipe' => 'eqp_higienizacao_extra',
            ],

            // submenu para o grupo de lavanderia

            [
                'description' => 'Piso',
                'icon' => '',
                'active' => true,
                'refmenu' => 4,
                'order' => 1,
                'type' => 'submenu',
                'grupo' => 'grp_lavanderia',
                'atividade' => 'atv_lav_abast_roupa',
                'aceitar' => 'atv_lav_aceitar',
                'equipe' => 'eqp_lvd',
            ],
            [
                'description' => 'Bata',
                'icon' => '',
                'active' => true,
                'refmenu' => 4,
                'order' => 2,
                'type' => 'submenu',
                'grupo' => 'grp_lavanderia',
                'atividade' => 'atv_lav_abast_roupa',
                'aceitar' => 'atv_lav_aceitar',
                'equipe' => 'eqp_lvd',
            ],
            [
                'description' => 'Cobertor',
                'icon' => '',
                'active' => true,
                'refmenu' => 4,
                'order' => 3,
                'type' => 'submenu',
                'grupo' => 'grp_lavanderia',
                'atividade' => 'atv_lav_abast_roupa',
                'aceitar' => 'atv_lav_aceitar',
                'equipe' => 'eqp_lvd',
            ],
            [
                'description' => 'Fronha',
                'icon' => '',
                'active' => true,
                'refmenu' => 4,
                'order' => 4,
                'type' => 'submenu',
                'grupo' => 'grp_lavanderia',
                'atividade' => 'atv_lav_abast_roupa',
                'aceitar' => 'atv_lav_aceitar',
                'equipe' => 'eqp_lvd',
            ],
            [
                'description' => 'Travesseiro',
                'icon' => '',
                'active' => true,
                'refmenu' => 4,
                'order' => 5,
                'type' => 'submenu',
                'grupo' => 'grp_lavanderia',
                'atividade' => 'atv_lav_abast_roupa',
                'aceitar' => 'atv_lav_aceitar',
                'equipe' => 'eqp_lvd',
            ],
            [
                'description' => 'Toalha',
                'icon' => '',
                'active' => true,
                'refmenu' => 4,
                'order' => 6,
                'type' => 'submenu',
                'grupo' => 'grp_lavanderia',
                'atividade' => 'atv_lav_abast_roupa',
                'aceitar' => 'atv_lav_aceitar',
                'equipe' => 'eqp_lvd',
            ],
            [
                'description' => 'Lençol de Acompanhante',
                'icon' => '',
                'active' => true,
                'refmenu' => 4,
                'order' => 7,
                'type' => 'submenu',
                'grupo' => 'grp_lavanderia',
                'atividade' => 'atv_lav_abast_roupa',
                'aceitar' => 'atv_lav_aceitar',
                'equipe' => 'eqp_lvd',
            ],
            [
                'description' => 'Lençol',
                'icon' => '',
                'active' => true,
                'refmenu' => 4,
                'order' => 8,
                'type' => 'submenu',
                'grupo' => 'grp_lavanderia',
                'atividade' => 'atv_lav_abast_roupa',
                'aceitar' => 'atv_lav_aceitar',
                'equipe' => 'eqp_lvd',
            ],

            // submenu para o grupo de servico social

            [
                'description' => 'Atendimento Serviço Social',
                'icon' => '',
                'active' => true,
                'refmenu' => 3,
                'order' => 1,
                'type' => 'submenu',
                'grupo' => 'grp_servico_social',
                'atividade' => 'atv_ssc_atendimento_solic',
                'aceitar' => 'atv_ssc_aceitar',
                'equipe' => 'eqp_servico_social',
            ],

            // submenu para o grupo de Psicólogos

            [
                'description' => 'Atendimento Psicológico',
                'icon' => '',
                'active' => true,
                'refmenu' => 5,
                'order' => 1,
                'type' => 'submenu',
                'grupo' => 'grp_psicologia',
                'atividade' => 'atv_psi_atend_solic_pac',
                'aceitar' => 'atv_psi_aceitar',
                'equipe' => 'eqp_psicologos',
            ],

            // submenu para o grupo de Hospitalidade

            [
                'description' => 'Atendimento Hospitalidade',
                'icon' => '',
                'active' => true,
                'refmenu' => 6,
                'order' => 1,
                'type' => 'submenu',
                'grupo' => 'grp_hospitalidade',
                'atividade' => 'atv_hosp_visita_pac',
                'aceitar' => 'atv_hosp_aceitar',
                'equipe' => 'eqp_hospitalidade',
            ],


        ];

        foreach ($menus as $menu) {
            
            menu::create($menu);

        }
    }
}
