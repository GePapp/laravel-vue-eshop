<?php

use Illuminate\Database\Seeder;

class MapsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $map = new \App\Map([
          'imageName' => 'stadtplanB.jpg',
          'title' => 'Stadtplan Berlin',
          'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.
          At vero eos et accusam et justo duo dolores et ea rebum.',
          'price' => 11.80
      ]);
      $map->save();

      $map = new \App\Map([
          'imageName' => 'stadtplanM.jpg',
          'title' => 'Stadtplan München',
          'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.
          At vero eos et accusam et justo duo dolores et ea rebum.',
          'price' => 9.80
      ]);
      $map->save();

      $map = new \App\Map([
          'imageName' => 'stadtplanK.jpg',
          'title' => 'Stadtplan Köln',
          'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.
          At vero eos et accusam et justo duo dolores et ea rebum.',
          'price' => 11.80
      ]);
      $map->save();

      $map = new \App\Map([
          'imageName' => 'stadtplanW.jpg',
          'title' => 'Stadtplan Wien',
          'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.
          At vero eos et accusam et justo duo dolores et ea rebum.',
          'price' => 14.50
      ]);
      $map->save();

      $map = new \App\Map([
          'imageName' => 'AstroKarteDE.jpg',
          'title' => 'Astrologische Landkarte Deutschland',
          'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.
          At vero eos et accusam et justo duo dolores et ea rebum.',
          'price' => 21.00
      ]);
      $map->save();

      $map = new \App\Map([
          'imageName' => 'AstroKarteAU.jpg',
          'title' => 'Astrologische Landkarte Südbayern - Österreich',
          'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.
          At vero eos et accusam et justo duo dolores et ea rebum.',
          'price' => 11.50
      ]);
      $map->save();
    }
}
