<?php


namespace Database\Seeders;


use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //admin
        $admin = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'nom_distribuidora' => 'admin',
            'fec_acceso' => now(),
            'ind_pf' => 'true',
            'ind_ct' => 'true',
            'ind_cups' => 'true',
            'ind_sabt' => 'false',
            'cod_id_group' => 'admin',
            'remember_token' => Str::random(10),
        ]);
        $admin->assignRole('admin');


        //CELA
        $user1 = User::factory()->create([
            'name' => 'Cela',
            'email' => 'cela@cela.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'nom_distribuidora' => 'Cela',
            'fec_acceso' => now(),
            'ind_pf' => 'true',
            'ind_ct' => 'true',
            'ind_cups' => 'true',
            'ind_sabt' => 'false',
            'cod_id_group' => '4',
            'remember_token' => Str::random(10),
        ]);
        $user1->assignRole('user');


        //Chera
        $user2 = User::factory()->create([
            'name' => 'Chera',
            'email' => 'chera@chera.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'nom_distribuidora' => 'Chera',
            'fec_acceso' => now(),
            'ind_pf' => 'true',
            'ind_ct' => 'true',
            'ind_cups' => 'true',
            'ind_sabt' => 'false',
            'cod_id_group' => '7',
            'remember_token' => Str::random(10),
        ]);
        $user2->assignRole('user');


        //Sotdechera
        $user3 = User::factory()->create([
            'name' => 'Sotdechera',
            'email' => 'sotdechera@sotdechera.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'nom_distribuidora' => 'Sotdechera',
            'fec_acceso' => now(),
            'ind_pf' => 'true',
            'ind_ct' => 'true',
            'ind_cups' => 'true',
            'ind_sabt' => 'false',
            'cod_id_group' => '9',
            'remember_token' => Str::random(10),
        ]);
        $user3->assignRole('user');


        //Biosca
        $user4 = User::factory()->create([
            'name' => 'Biosca',
            'email' => 'biosca@biosca.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'nom_distribuidora' => 'Biosca',
            'fec_acceso' => now(),
            'ind_pf' => 'true',
            'ind_ct' => 'true',
            'ind_cups' => 'true',
            'ind_sabt' => 'false',
            'cod_id_group' => '13',
            'remember_token' => Str::random(10),
        ]);
        $user4->assignRole('user');


        //Santaclara
        $user5 = User::factory()->create([
            'name' => 'Santaclara',
            'email' => 'santaclara@santaclara.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'nom_distribuidora' => 'Santaclara',
            'fec_acceso' => now(),
            'ind_pf' => 'false',
            'ind_ct' => 'true',
            'ind_cups' => 'true',
            'ind_sabt' => 'false',
            'cod_id_group' => ' ',
            'remember_token' => Str::random(10),
        ]);
        $user5->assignRole('user');


        //Alvarobenito
        $user6 = User::factory()->create([
            'name' => 'Alvarobenito',
            'email' => 'alvarobenito@alvarobenito.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'nom_distribuidora' => 'Alvarobenito',
            'fec_acceso' => now(),
            'ind_pf' => 'false',
            'ind_ct' => 'true',
            'ind_cups' => 'true',
            'ind_sabt' => 'false',
            'cod_id_group' => ' ',
            'remember_token' => Str::random(10),
        ]);
        $user6->assignRole('user');


        //Vilaller
        $user7 = User::factory()->create([
            'name' => 'Vilaller',
            'email' => 'vilaller@vilaller.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'nom_distribuidora' => 'Vilaller',
            'fec_acceso' => now(),
            'ind_pf' => 'false',
            'ind_ct' => 'true',
            'ind_cups' => 'true',
            'ind_sabt' => 'false',
            'cod_id_group' => ' ',
            'remember_token' => Str::random(10),
        ]);
        $user7->assignRole('user');


        //Sampol
        $user8 = User::factory()->create([
            'name' => 'Sampol',
            'email' => 'sampol@sampol.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'nom_distribuidora' => 'Sampol',
            'fec_acceso' => now(),
            'ind_pf' => 'false',
            'ind_ct' => 'true',
            'ind_cups' => 'true',
            'ind_sabt' => 'false',
            'cod_id_group' => ' ',
            'remember_token' => Str::random(10),
        ]);
        $user8->assignRole('user');


        //Pastor
        $user9 = User::factory()->create([
            'name' => 'Pastor',
            'email' => 'pastor@pastor.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'nom_distribuidora' => 'Pastor',
            'fec_acceso' => now(),
            'ind_pf' => 'true',
            'ind_ct' => 'true',
            'ind_cups' => 'true',
            'ind_sabt' => 'false',
            'cod_id_group' => '2',
            'remember_token' => Str::random(10),
        ]);
        $user9->assignRole('user');


        //Mercedes
        $user10 = User::factory()->create([
            'name' => 'Mercedes',
            'email' => 'mercedes@mercedes.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'nom_distribuidora' => 'Mercedes',
            'fec_acceso' => now(),
            'ind_pf' => 'false',
            'ind_ct' => 'true',
            'ind_cups' => 'true',
            'ind_sabt' => 'false',
            'cod_id_group' => ' ',
            'remember_token' => Str::random(10),
        ]);
        $user10->assignRole('user');


        //Hnoscastro
        $user11 = User::factory()->create([
            'name' => 'Hnoscastro',
            'email' => 'hnoscastro@hnoscastro.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'nom_distribuidora' => 'Hnoscastro',
            'fec_acceso' => now(),
            'ind_pf' => 'false',
            'ind_ct' => 'true',
            'ind_cups' => 'true',
            'ind_sabt' => 'false',
            'cod_id_group' => ' ',
            'remember_token' => Str::random(10),
        ]);
        $user11->assignRole('user');




        //Alconera
        $user12 = User::factory()->create([
            'name' => 'Alconera',
            'email' => 'alconera@alconera.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'nom_distribuidora' => 'Alconera',
            'fec_acceso' => now(),
            'ind_pf' => 'true',
            'ind_ct' => 'true',
            'ind_cups' => 'true',
            'ind_sabt' => 'false',
            'cod_id_group' => '15',
            'remember_token' => Str::random(10),
        ]);
        $user12->assignRole('user');


        //Meliana
        $user13 = User::factory()->create([
            'name' => 'Meliana',
            'email' => 'meliana@meliana.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'nom_distribuidora' => 'Meliana',
            'fec_acceso' => now(),
            'ind_pf' => 'false',
            'ind_ct' => 'true',
            'ind_cups' => 'true',
            'ind_sabt' => 'false',
            'cod_id_group' => ' ',
            'remember_token' => Str::random(10),
        ]);
        $user13->assignRole('user');




        //Cerrajon
        $user14 = User::factory()->create([
            'name' => 'Cerrajon',
            'email' => 'cerrajon@cerrajon.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'nom_distribuidora' => 'Cerrajon',
            'fec_acceso' => now(),
            'ind_pf' => 'true',
            'ind_ct' => 'true',
            'ind_cups' => 'true',
            'ind_sabt' => 'false',
            'cod_id_group' => '3',
            'remember_token' => Str::random(10),
        ]);
        $user14->assignRole('user');


        //dielec
        $user15 = User::factory()->create([
            'name' => 'Dielec',
            'email' => 'dielec@dielec.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'nom_distribuidora' => 'Dielec',
            'fec_acceso' => now(),
            'ind_pf' => 'true',
            'ind_ct' => 'true',
            'ind_cups' => 'true',
            'ind_sabt' => 'false',
            'cod_id_group' => '12',
            'remember_token' => Str::random(10),
        ]);
        $user15->assignRole('user');


        //chulilla
        $user16 = User::factory()->create([
            'name' => 'Chulilla',
            'email' => 'chulilla@chulilla.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'nom_distribuidora' => 'Chulilla',
            'fec_acceso' => now(),
            'ind_pf' => 'true',
            'ind_ct' => 'true',
            'ind_cups' => 'true',
            'ind_sabt' => 'false',
            'cod_id_group' => '8',
            'remember_token' => Str::random(10),
        ]);
        $user16->assignRole('user');


        //coelca
        $user17 = User::factory()->create([
            'name' => 'Coelca',
            'email' => 'coelca@coelca.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'nom_distribuidora' => 'Coelca',
            'fec_acceso' => now(),
            'ind_pf' => 'false',
            'ind_ct' => 'true',
            'ind_cups' => 'true',
            'ind_sabt' => 'false',
            'cod_id_group' => ' ',
            'remember_token' => Str::random(10),
        ]);
        $user17->assignRole('user');




        //Hidroelcarmen
        $user18 = User::factory()->create([
            'name' => 'Hidroelcarmen',
            'email' => 'hidroelcarmen@hidroelcarmen.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'nom_distribuidora' => 'Hidroelcarmen',
            'fec_acceso' => now(),
            'ind_pf' => 'false',
            'ind_ct' => 'true',
            'ind_cups' => 'true',
            'ind_sabt' => 'false',
            'cod_id_group' => ' ',
            'remember_token' => Str::random(10),
        ]);
        $user18->assignRole('user');


        //Lijar
        $user19 = User::factory()->create([
            'name' => 'Lijar',
            'email' => 'lijar@lijar.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'nom_distribuidora' => 'Lijar',
            'fec_acceso' => now(),
            'ind_pf' => 'true',
            'ind_ct' => 'false',
            'ind_cups' => 'false',
            'ind_sabt' => 'false',
            'cod_id_group' => '1',
            'remember_token' => Str::random(10),
        ]);
        $user19->assignRole('user');


        //Acsi
        $user20 = User::factory()->create([
            'name' => 'Acsi',
            'email' => 'acsi@acsi.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'nom_distribuidora' => 'Acsi',
            'fec_acceso' => now(),
            'ind_pf' => 'true',
            'ind_ct' => 'false',
            'ind_cups' => 'false',
            'ind_sabt' => 'false',
            'cod_id_group' => '11',
            'remember_token' => Str::random(10),
        ]);
        $user20->assignRole('user');




        //Llavorsi
        $user21 = User::factory()->create([
            'name' => 'Llavorsi',
            'email' => 'llavorsi@llavorsi.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'nom_distribuidora' => 'Llavorsi',
            'fec_acceso' => now(),
            'ind_pf' => 'true',
            'ind_ct' => 'false',
            'ind_cups' => 'false',
            'ind_sabt' => 'false',
            'cod_id_group' => '10',
            'remember_token' => Str::random(10),
        ]);
        $user21->assignRole('user');

        //Talayuelas
        $user22 = User::factory()->create([
            'name' => 'Talayuelas',
            'email' => 'talayuelas@talayuelas.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'nom_distribuidora' => 'Talayuelas',
            'fec_acceso' => now(),
            'ind_pf' => 'false',
            'ind_ct' => 'true',
            'ind_cups' => 'true',
            'ind_sabt' => 'false',
            'cod_id_group' => '',
            'remember_token' => Str::random(10),
        ]);
        $user22->assignRole('user');

        //Laprohida
        $user23 = User::factory()->create([
            'name' => 'Laprohida',
            'email' => 'laprohida@laprohida.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'nom_distribuidora' => 'Laprohida',
            'fec_acceso' => now(),
            'ind_pf' => 'false',
            'ind_ct' => 'true',
            'ind_cups' => 'true',
            'ind_sabt' => 'false',
            'cod_id_group' => '',
            'remember_token' => Str::random(10),
        ]);
        $user23->assignRole('user');
    }
}
