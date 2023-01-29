<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        DB::table('permissions')->insert([
            /** ACL  1 to 11 */
            [
                'name' => 'Acessar ACL',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Permissões',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Permissões',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Permissões',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Permissões',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Perfis',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Perfis',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Perfis',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Perfis',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Sincronizar Perfis',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Atribuir Perfis',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Settings Access 12 */
            [
                'name' => 'Acessar Configurações',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Genres 13 to 17 */
            [
                'name' => 'Acessar Gêneros',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Gêneros',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Gêneros',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Gêneros',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Gêneros',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Users 18 to 22 */
            [
                'name' => 'Acessar Usuários',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Usuários',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Usuários',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Usuários',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Usuários',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Complex 23 to 27 */
            [
                'name' => 'Acessar Condomínios',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Condomínios',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Condomínios',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Condomínios',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Condomínios',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Complex 28 to 32 */
            [
                'name' => 'Acessar Blocos',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Blocos',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Blocos',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Blocos',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Blocos',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Apartments 33 to 37 */
            [
                'name' => 'Acessar Apartamentos',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Apartamentos',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Apartamentos',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Apartamentos',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Apartamentos',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Type Meters 38 a  42*/
            [
                'name' => 'Acessar Tipos de Medidores',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Tipos de Medidores',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Tipos de Medidores',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Tipos de Medidores',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Tipos de Medidores',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Meters 43 to 47 */
            [
                'name' => 'Acessar Medidores',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Medidores',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Medidores',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Medidores',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Medidores',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Residents 48 to 52 */
            [
                'name' => 'Acessar Moradores',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Moradores',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Moradores',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Moradores',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Moradores',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Syndics 53 to 57 */
            [
                'name' => 'Acessar Síndicos',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Síndicos',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Síndicos',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Síndicos',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Síndicos',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Readings 58 to 62 */
            [
                'name' => 'Acessar Leituras',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Leituras',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Leituras',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Leituras',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Leituras',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Dealerships 63 67 */
            [
                'name' => 'Acessar Concessionárias',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Concessionárias',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Concessionárias',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Concessionárias',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Concessionárias',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Dealerships Readings 68 to 72 */
            [
                'name' => 'Acessar Leitura das Concessionárias',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Leitura das Concessionárias',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Leitura das Concessionárias',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Leitura das Concessionárias',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Leitura das Concessionárias',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Application 73 */
            [
                'name' => 'Editar Usuário',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Appartments Reading  74 */
            [
                'name' => 'Acessar Leituras Apartamento',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Edit Perfil Application 75 */
            [
                'name' => 'Editar Perfil na Aplicação',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Access Meter Reading by Apartment 76 */
            [
                'name' => 'Acessar Medições Apartamento',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Support 77 to 78 */
            [
                'name' => 'Visualizar Suporte',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Enviar Suporte',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Advertisements 79 to 83 */
            [
                'name' => 'Acessar Propagandas',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Propagandas',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Propagandas',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Propagandas',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Propagandas',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Posts 84 to 88 */
            [
                'name' => 'Acessar Posts',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Posts',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Posts',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Posts',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Posts',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],

            /** Reports 89 to 92 */
            [
                'name' => 'Listar Relatórios',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Relatórios',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Relatórios',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Relatórios',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Schedules 93 to 97 */
            [
                'name' => 'Acessar Agenda',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Eventos na Agenda',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Eventos na Agenda',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Eventos na Agenda',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Eventos na Agenda',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Reading Schedule 98 to 102 */
            [
                'name' => 'Acessar Agendamentos de Leitura',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Agendamentos de Leitura',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Agendamentos de Leitura',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Agendamentos de Leitura',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Agendamentos de Leitura',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Management Reports 103 to 105*/
            [
                'name' => 'Acessar Relatórios Gerenciais',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Relatório de Condomínios',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Relatório de Leitura X Leiturista',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
        ]);
    }
}
