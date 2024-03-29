<?php

namespace Database\Seeders\Users;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Symfony\Polyfill\Uuid\Uuid;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => '1a80b3d0-89b8-40d8-8e85-cb643f022fb9',
                'superior_uuid' => '',
                'name' => 'Иван Иванович',
                'email' => 'boss@boss.ru',
                'phone' => '999-816-45-84',
                'position' => 'Руководитель организации',
                'birthday_at' => '1970-01-01',
                'email_verified_at' => now(),
                'password' => '$2y$10$wCv1t74ruEq.ijydsd4zYuJZSg3LnWoNmShVfdy0JicSYnDLUK5Ae', // password
            ],
            [
                'id' => '0c91a116-6127-43d9-95bb-c09fa39fb455',
                'superior_uuid' => '1a80b3d0-89b8-40d8-8e85-cb643f022fb9',
                'name' => 'Валентина Валентиновна',
                'email' => 'kadr@kadr.ru',
                'phone' => '999-254-36-85',
                'position' => 'Специалист по кадровому делопроизводству',
                'birthday_at' => '1980-01-20',
                'email_verified_at' => now(),
                'password' => '$2y$10$wCv1t74ruEq.ijydsd4zYuJZSg3LnWoNmShVfdy0JicSYnDLUK5Ae', // password
            ],
            [
                'id' => 'b9e7a020-492e-47b3-8055-6a59a2bfbe36',
                'superior_uuid' => '1a80b3d0-89b8-40d8-8e85-cb643f022fb9',
                'name' => 'Ольга Олеговна',
                'email' => 'delo@delo.ru',
                'phone' => '999-654-32-85',
                'position' => 'Секретарь-делопроизводитель',
                'birthday_at' => '1980-01-30',
                'email_verified_at' => now(),
                'password' => '$2y$10$wCv1t74ruEq.ijydsd4zYuJZSg3LnWoNmShVfdy0JicSYnDLUK5Ae', // password
            ],
            [
                'id' => 'e75fb917-4d70-44d2-8560-c785aff50780',
                'superior_uuid' => '1a80b3d0-89b8-40d8-8e85-cb643f022fb9',
                'name' => 'Анатолий Иванович',
                'email' => 'o1@o1.ru',
                'phone' => '999-985-36-45',
                'position' => 'Начальник 1 отдела',
                'birthday_at' => '1980-01-01',
                'email_verified_at' => now(),
                'password' => '$2y$10$wCv1t74ruEq.ijydsd4zYuJZSg3LnWoNmShVfdy0JicSYnDLUK5Ae', // password
            ],
            [
                'id' => '7d9a3510-5118-4cd9-ac9d-0b9fda8c3ed9',
                'superior_uuid' => '1a80b3d0-89b8-40d8-8e85-cb643f022fb9',
                'name' => 'Борис Иванович',
                'email' => 'o2@o2.ru',
                'phone' => '999-368-96-77',
                'position' => 'Начальник 2 отдела',
                'birthday_at' => '1980-02-02',
                'email_verified_at' => now(),
                'password' => '$2y$10$wCv1t74ruEq.ijydsd4zYuJZSg3LnWoNmShVfdy0JicSYnDLUK5Ae', // password
            ],
            [
                'id' => '9d5b1b8a-03bb-40db-b795-c98b8f898352',
                'superior_uuid' => '1a80b3d0-89b8-40d8-8e85-cb643f022fb9',
                'name' => 'Владимир Иванович',
                'email' => 'o3@o3.ru',
                'phone' => '999-848-36-75',
                'position' => 'Начальник 3 отдела',
                'birthday_at' => '1980-03-03',
                'email_verified_at' => now(),
                'password' => '$2y$10$wCv1t74ruEq.ijydsd4zYuJZSg3LnWoNmShVfdy0JicSYnDLUK5Ae', // password
            ],
            [
                'id' => '37eb9897-568a-4af1-a0a8-244d3f697487',
                'superior_uuid' => '1a80b3d0-89b8-40d8-8e85-cb643f022fb9',
                'name' => 'Геннадий Иванович',
                'email' => 'o4@o4.ru',
                'phone' => '999-965-35-42',
                'position' => 'Начальник 4 отдела',
                'birthday_at' => '1980-04-04',
                'email_verified_at' => now(),
                'password' => '$2y$10$wCv1t74ruEq.ijydsd4zYuJZSg3LnWoNmShVfdy0JicSYnDLUK5Ae', // password
            ],
            [
                'id' => '997b70af-8ffd-45e1-9937-02378284d93c',
                'superior_uuid' => 'e75fb917-4d70-44d2-8560-c785aff50780',
                'name' => 'Артем Анатольевич',
                'email' => 'o1s1@o1s1.ru',
                'phone' => '999-365-54-86',
                'position' => 'Специалист 1 отдела',
                'birthday_at' => '1990-01-01',
                'email_verified_at' => now(),
                'password' => '$2y$10$wCv1t74ruEq.ijydsd4zYuJZSg3LnWoNmShVfdy0JicSYnDLUK5Ae', // password
            ],
            [
                'id' => '871ccdbe-067e-45ad-9926-c723b08eaec4',
                'superior_uuid' => 'e75fb917-4d70-44d2-8560-c785aff50780',
                'name' => 'Богдан Анатольевич',
                'email' => 'o1s2@o1s2.ru',
                'phone' => '999-745-85-22',
                'position' => 'Специалист 1 отдела',
                'birthday_at' => '1990-01-10',
                'email_verified_at' => now(),
                'password' => '$2y$10$wCv1t74ruEq.ijydsd4zYuJZSg3LnWoNmShVfdy0JicSYnDLUK5Ae', // password
            ],
            [
                'id' => 'e7474977-f7d3-4e0b-ae11-49c14f6c2c26',
                'superior_uuid' => 'e75fb917-4d70-44d2-8560-c785aff50780',
                'name' => 'Валерий Анатольевич',
                'email' => 'o1s3@o1s3.ru',
                'phone' => '999-965-85-33',
                'position' => 'Специалист 1 отдела',
                'birthday_at' => '1990-01-20',
                'email_verified_at' => now(),
                'password' => '$2y$10$wCv1t74ruEq.ijydsd4zYuJZSg3LnWoNmShVfdy0JicSYnDLUK5Ae', // password
            ],
            [
                'id' => 'a9dbf6a6-0ecf-4445-b612-f720eebfaf4e',
                'superior_uuid' => 'e75fb917-4d70-44d2-8560-c785aff50780',
                'name' => 'Георгий Анатольевич',
                'email' => 'o1s4@o1s4.ru',
                'phone' => '999-112-58-88',
                'position' => 'Специалист 1 отдела',
                'birthday_at' => '1990-01-30',
                'email_verified_at' => now(),
                'password' => '$2y$10$wCv1t74ruEq.ijydsd4zYuJZSg3LnWoNmShVfdy0JicSYnDLUK5Ae', // password
            ],
            [
                'id' => '7dc4aa86-c5e2-42f5-9d09-9ac2929295f3',
                'superior_uuid' => '7d9a3510-5118-4cd9-ac9d-0b9fda8c3ed9',
                'name' => 'Артемий Борисович',
                'email' => 'o2s1@o2s1.ru',
                'phone' => '999-587-66-87',
                'position' => 'Специалист 2 отдела',
                'birthday_at' => '1990-02-01',
                'email_verified_at' => now(),
                'password' => '$2y$10$wCv1t74ruEq.ijydsd4zYuJZSg3LnWoNmShVfdy0JicSYnDLUK5Ae', // password
            ],
            [
                'id' => '38373b78-9023-4332-9462-a191bf341666',
                'superior_uuid' => '7d9a3510-5118-4cd9-ac9d-0b9fda8c3ed9',
                'name' => 'Бронислав Борисович',
                'email' => 'o2s2@o2s2.ru',
                'phone' => '999-663-99-85',
                'position' => 'Специалист 2 отдела',
                'birthday_at' => '1990-02-10',
                'email_verified_at' => now(),
                'password' => '$2y$10$wCv1t74ruEq.ijydsd4zYuJZSg3LnWoNmShVfdy0JicSYnDLUK5Ae', // password
            ],
            [
                'id' => 'b775b419-cfd2-4ae6-ad2b-a3a4e5d39343',
                'superior_uuid' => '7d9a3510-5118-4cd9-ac9d-0b9fda8c3ed9',
                'name' => 'Вера Борисовна',
                'email' => 'o2s3@o2s3.ru',
                'phone' => '999-365-96-77',
                'position' => 'Специалист 2 отдела',
                'birthday_at' => '1990-02-20',
                'email_verified_at' => now(),
                'password' => '$2y$10$wCv1t74ruEq.ijydsd4zYuJZSg3LnWoNmShVfdy0JicSYnDLUK5Ae', // password
            ],
            [
                'id' => 'a8c316e9-9d48-4547-9d4c-c91fb05540a2',
                'superior_uuid' => '7d9a3510-5118-4cd9-ac9d-0b9fda8c3ed9',
                'name' => 'Глеб Борисович',
                'email' => 'o2s4@o2s4.ru',
                'phone' => '999-236-88-74',
                'position' => 'Специалист 2 отдела',
                'birthday_at' => '1990-02-25',
                'email_verified_at' => now(),
                'password' => '$2y$10$wCv1t74ruEq.ijydsd4zYuJZSg3LnWoNmShVfdy0JicSYnDLUK5Ae', // password
            ],
            [
                'id' => '06b66523-17a5-4d7a-b387-f0671d71b7f6',
                'superior_uuid' => '9d5b1b8a-03bb-40db-b795-c98b8f898352',
                'name' => 'Алиса Владимировна',
                'email' => 'o3s1@o3s1.ru',
                'phone' => '999-254-99-74',
                'position' => 'Специалист 3 отдела',
                'birthday_at' => '1990-03-01',
                'email_verified_at' => now(),
                'password' => '$2y$10$wCv1t74ruEq.ijydsd4zYuJZSg3LnWoNmShVfdy0JicSYnDLUK5Ae', // password
            ],
            [
                'id' => '3d5145fe-f840-45cb-8f3f-eb9b5c5d8758',
                'superior_uuid' => '9d5b1b8a-03bb-40db-b795-c98b8f898352',
                'name' => 'Берта Владимировна',
                'email' => 'o3s2@o3s2.ru',
                'phone' => '999-236-86-97',
                'position' => 'Специалист 3 отдела',
                'birthday_at' => '1990-03-10',
                'email_verified_at' => now(),
                'password' => '$2y$10$wCv1t74ruEq.ijydsd4zYuJZSg3LnWoNmShVfdy0JicSYnDLUK5Ae', // password
            ],
            [
                'id' => '3eab0e12-7a14-495e-9e5a-dcfa3d37ea6c',
                'superior_uuid' => '9d5b1b8a-03bb-40db-b795-c98b8f898352',
                'name' => 'Вениамин Владимирович',
                'email' => 'o3s3@o3s3.ru',
                'phone' => '999-145-87-88',
                'position' => 'Специалист 3 отдела',
                'birthday_at' => '1990-03-20',
                'email_verified_at' => now(),
                'password' => '$2y$10$wCv1t74ruEq.ijydsd4zYuJZSg3LnWoNmShVfdy0JicSYnDLUK5Ae', // password
            ],
            [
                'id' => 'dfe0c326-61c8-4c30-b50b-1ddb4c711ab8',
                'superior_uuid' => '9d5b1b8a-03bb-40db-b795-c98b8f898352',
                'name' => 'Герман Владимирович',
                'email' => 'o3s4@o3s4.ru',
                'phone' => '999-254-87-96',
                'position' => 'Специалист 3 отдела',
                'birthday_at' => '1990-03-30',
                'email_verified_at' => now(),
                'password' => '$2y$10$wCv1t74ruEq.ijydsd4zYuJZSg3LnWoNmShVfdy0JicSYnDLUK5Ae', // password
            ],
            [
                'id' => '6ad75659-9ee2-4bbf-920d-74815f5d46b4',
                'superior_uuid' => '37eb9897-568a-4af1-a0a8-244d3f697487',
                'name' => 'Алла Геннадьевна',
                'email' => 'o4s1@o4s1.ru',
                'phone' => '999-145-89-66',
                'position' => 'Специалист 4 отдела',
                'birthday_at' => '1990-04-01',
                'email_verified_at' => now(),
                'password' => '$2y$10$wCv1t74ruEq.ijydsd4zYuJZSg3LnWoNmShVfdy0JicSYnDLUK5Ae', // password
            ],
            [
                'id' => '32df05dd-f66b-4994-b127-aa77872fadea',
                'superior_uuid' => '37eb9897-568a-4af1-a0a8-244d3f697487',
                'name' => 'Белла Геннадьевна',
                'email' => 'o4s2@o4s2.ru',
                'phone' => '999-365-79-85',
                'position' => 'Специалист 4 отдела',
                'birthday_at' => '1990-04-10',
                'email_verified_at' => now(),
                'password' => '$2y$10$wCv1t74ruEq.ijydsd4zYuJZSg3LnWoNmShVfdy0JicSYnDLUK5Ae', // password
            ],
            [
                'id' => '1f374bd2-2113-4945-8651-bb7268023a2b',
                'superior_uuid' => '37eb9897-568a-4af1-a0a8-244d3f697487',
                'name' => 'Валентин Геннадьевич',
                'email' => 'o4s3@o4s3.ru',
                'phone' => '999-225-65-88',
                'position' => 'Специалист 4 отдела',
                'birthday_at' => '1990-04-20',
                'email_verified_at' => now(),
                'password' => '$2y$10$wCv1t74ruEq.ijydsd4zYuJZSg3LnWoNmShVfdy0JicSYnDLUK5Ae', // password
             ],
            [
                'id' => 'a48c76ac-e787-4979-b075-7f1cdd46c16f',
                'superior_uuid' => '37eb9897-568a-4af1-a0a8-244d3f697487',
                'name' => 'Галина Геннадьевна',
                'email' => 'o4s4@o4s4.ru',
                'phone' => '999-336-46-79',
                'position' => 'Специалист 4 отдела',
                'birthday_at' => '1990-04-30',
                'email_verified_at' => now(),
                'password' => '$2y$10$wCv1t74ruEq.ijydsd4zYuJZSg3LnWoNmShVfdy0JicSYnDLUK5Ae', // password
            ]
       ]);

    }
}
