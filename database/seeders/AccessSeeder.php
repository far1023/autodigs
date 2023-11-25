<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AccessSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$permissions = [
			[
				"name" => "access control-room",
				"group" => "Control Access"
			],
			[
				"name" => "add role",
				"group" => "Control Access"
			],
			[
				"name" => "edit role",
				"group" => "Control Access"
			],
			[
				"name" => "delete role",
				"group" => "Control Access"
			],
			[
				"name" => "add permission",
				"group" => "Control Access"
			],
			[
				"name" => "edit permission",
				"group" => "Control Access"
			],
			[
				"name" => "delete permission",
				"group" => "Control Access"
			],
			[
				"name" => "grant permission",
				"group" => "Control Access"
			],
			[
				"name" => "show user",
				"group" => "User Section"
			],
			[
				"name" => "add user",
				"group" => "User Section"
			],
			[
				"name" => "edit user",
				"group" => "User Section"
			],
			[
				"name" => "delete user",
				"group" => "User Section"
			],
		];

		foreach ($permissions as $item) {
			Permission::firstOrCreate($item);
		}
	}
}
