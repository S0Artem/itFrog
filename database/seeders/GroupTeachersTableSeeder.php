<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupTeachersTableSeeder extends Seeder
{
    public function run()
    {
        $groupTeachers = [];
        $groups = DB::table('groups')->get();
        $teachersByBranch = [
            1 => [2, 6], // Москва
            2 => [3, 7], // СПб
            3 => [4],    // Новосибирск
            4 => [5]     // Екатеринбург
        ];

        foreach ($groups as $group) {
            $branchId = $group->branch_id;
            $teacherId = $teachersByBranch[$branchId][array_rand($teachersByBranch[$branchId])];
            
            $groupTeachers[] = [
                'employee_id' => $teacherId,
                'group_id' => $group->id,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::table('group_teachers')->insert($groupTeachers);
    }
}