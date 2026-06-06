<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@appointment.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'gender'   => 'Male',
            'address'  => 'Manila, Philippines',
            'phone'    => '09171234567',
        ]);

        $user = User::create([
            'name'     => 'Juan Dela Cruz',
            'email'    => 'juan@appointment.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
            'gender'   => 'Male',
            'phone'    => '09281234567',
        ]);

        $appointments = [
            ['title'=>'Hair Cut - Mark',   'client_name'=>'Mark Santos',   'service'=>'Haircut',      'client_phone'=>'09171111111','appointment_date'=>now()->addDay(),   'duration'=>30, 'status'=>'Scheduled'],
            ['title'=>'Full Body Massage', 'client_name'=>'Anna Reyes',    'service'=>'Massage',      'client_phone'=>'09172222222','appointment_date'=>now()->addDays(2), 'duration'=>60, 'status'=>'Scheduled'],
            ['title'=>'Dental Checkup',    'client_name'=>'Pedro Cruz',    'service'=>'Consultation', 'client_phone'=>'09173333333','appointment_date'=>now()->addDays(3), 'duration'=>45, 'status'=>'Scheduled'],
            ['title'=>'Nail Art Session',  'client_name'=>'Maria Lim',     'service'=>'Nail Art',     'client_phone'=>'09174444444','appointment_date'=>now()->subDay(),   'duration'=>90, 'status'=>'Completed'],
            ['title'=>'Eye Brow Threading','client_name'=>'Rosa Garcia',   'service'=>'Threading',    'client_phone'=>'09175555555','appointment_date'=>now()->subDays(2), 'duration'=>15, 'status'=>'Completed'],
            ['title'=>'Facial Treatment',  'client_name'=>'Jose Bautista', 'service'=>'Facial',       'client_phone'=>'09176666666','appointment_date'=>now()->subDays(3), 'duration'=>60, 'status'=>'Cancelled'],
        ];

        foreach ($appointments as $a) {
            Appointment::create(array_merge($a, ['user_id'=>$admin->id, 'client_email'=>null, 'notes'=>null]));
        }

        Appointment::create([
            'user_id'=>$user->id, 'title'=>'Business Consultation',
            'client_name'=>'Carlo Mendoza', 'service'=>'Consultation',
            'appointment_date'=>now()->addDays(5), 'duration'=>60,
            'status'=>'Scheduled', 'client_email'=>'carlo@email.com',
            'client_phone'=>'09189999999', 'notes'=>'Bring documents',
        ]);
    }
}
