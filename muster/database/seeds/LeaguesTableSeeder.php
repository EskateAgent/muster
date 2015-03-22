<?php

use Illuminate\Database\Seeder;

class LeaguesTableSeeder extends Seeder {

  public function run()
  {
    // Uncomment the below to wipe the table clean before populating
    DB::table('leagues')->delete();

    $leagues = array(
      ['id' => 1,  'name' => 'Auld Reekie Roller Girls',       'slug' => 'auld-reekie-roller-girls',       'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 2,  'name' => 'Basingstoke Bullets',            'slug' => 'basingstoke-bullets',            'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 3,  'name' => 'Belfast Roller Derby',           'slug' => 'belfast-roller-derby',           'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 4,  'name' => 'Big Bucks High Rollers',         'slug' => 'big-bucks-high-rollers',         'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 5,  'name' => 'Birmingham Blitz Dames',         'slug' => 'birmingham-blitz-dames',         'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 6,  'name' => 'Bourne Bombshells',              'slug' => 'bourne-bombshells',              'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 7,  'name' => 'Brighton Rockers',               'slug' => 'brighton-rockers',               'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 8,  'name' => 'Bristol Roller Derby',           'slug' => 'bristol-roller-derby',           'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 9,  'name' => 'Bruising Banditas Roller Derby', 'slug' => 'bruising-banditas-roller-derby', 'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 10, 'name' => 'Cambridge Rollerbillies',        'slug' => 'cambridge-rollerbillies',        'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 11, 'name' => 'Central City Rollergirls',       'slug' => 'central-city-rollergirls',       'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 12, 'name' => 'Crash Test Brummies',            'slug' => 'crash-test-brummies',            'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 13, 'name' => 'Croydon Roller Derby',           'slug' => 'croydon-roller-derby',           'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 14, 'name' => 'Dolly Rockit Rollers',           'slug' => 'dolly-rockit-rollers',           'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 15, 'name' => 'Dundee Roller Girls',            'slug' => 'dundee-roller-girls',            'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 16, 'name' => 'Fierce Valley Roller Girls',     'slug' => 'fierce-valley-roller-girls',     'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 17, 'name' => 'Glasgow Roller Derby',           'slug' => 'glasgow-roller-derby',           'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 18, 'name' => 'Granite City Roller Girls',      'slug' => 'granite-city-roller-girls',      'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 19, 'name' => 'Haunted City Rollers',           'slug' => 'haunted-city-rollers',           'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 20, 'name' => 'Hereford Roller Girls',          'slug' => 'hereford-roller-girls',          'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 21, 'name' => 'Hot Wheel Roller Derby',         'slug' => 'hot-wheel-roller-derby',         'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 22, 'name' => 'Hulls Angels Roller Dames',      'slug' => 'hulls-angelsroller-dames',       'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 23, 'name' => 'Kent Roller Girls',              'slug' => 'kent-roller-girls',              'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 24, 'name' => 'Leeds Roller Dolls',             'slug' => 'leeds-roller-dolls',             'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 25, 'name' => 'Lincolnshire Bombers',           'slug' => 'lincolnshire-bombers',           'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 26, 'name' => 'Liverpool Roller Birds',         'slug' => 'liverpool-roller-birds',         'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 27, 'name' => 'London Rockin\' Rollers',        'slug' => 'london-rockin-rollers',          'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 28, 'name' => 'London Rollergirls',             'slug' => 'london-rollergirls',             'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 29, 'name' => 'Manchester Roller Derby',        'slug' => 'manchester-roller-derby',        'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 30, 'name' => 'Middlesbrough Milk Rollers',     'slug' => 'middlesbrough-milk-rollers',     'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 31, 'name' => 'Milton Keynes Roller Derby',     'slug' => 'milton-keynes-roller-derby',     'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 32, 'name' => 'Neath Port Talbot Roller Derby', 'slug' => 'neath-port-talbot-roller-derby', 'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 33, 'name' => 'Newcastle Roller Girls',         'slug' => 'newcastle-roller-girls',         'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 34, 'name' => 'Norfolk Brawds',                 'slug' => 'norfolk-brawds',                 'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 35, 'name' => 'Nottingham Hellfire Harlots',    'slug' => 'nottingham-hellfire-harlots',    'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 36, 'name' => 'Oxford Roller Derby',            'slug' => 'oxford-roller-derby',            'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 37, 'name' => 'Plymouth City Roller Girls',     'slug' => 'plymouth-city-roller-girls',     'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 38, 'name' => 'Portsmouth Roller Wenches',      'slug' => 'portsmouth-roller-wenches',      'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 39, 'name' => 'Preston Roller Girls',           'slug' => 'preston-roller-girls',           'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 40, 'name' => 'Rainy City Rollergirls',         'slug' => 'rainy-city-rollergirls',         'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 41, 'name' => 'Reaper Roller Derby',            'slug' => 'reaper-roller-derby',            'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 42, 'name' => 'Rebellion Roller Derby',         'slug' => 'rebellion-roller-derby',         'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 43, 'name' => 'Roller Derby Leicester',         'slug' => 'roller-derby-leicester',         'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 44, 'name' => 'Royal Windsor Rollergirls',      'slug' => 'royal-windsor-rollergirls',      'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 45, 'name' => 'Seaside Siren Roller Girls',     'slug' => 'seaside-siren-roller-girls',     'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 46, 'name' => 'Severn Roller Torrent',          'slug' => 'severn-roller-torrent',          'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 47, 'name' => 'Sheffield Steel Rollergirls',    'slug' => 'sheffield-steel-rollergirls',    'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 48, 'name' => 'South West Angels of Terror',    'slug' => 'south-west-angels-of-terror',    'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 49, 'name' => 'Surrey Rollerboys',              'slug' => 'surrey-rollergirls',             'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 50, 'name' => 'Swansea City Roller Derby',      'slug' => 'swansea-city-roller-derby',      'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 51, 'name' => 'The Inhuman League',             'slug' => 'the-inhuman-league',             'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 52, 'name' => 'Tiger Bay Brawlers',             'slug' => 'tiger-bay-brawlers',             'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 53, 'name' => 'Wiltshire Roller Derby',         'slug' => 'wiltshire-roller-derby',         'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 54, 'name' => 'Wirral Whipiteres',              'slug' => 'wirral-whipieters',              'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 55, 'name' => 'Wolverhampton Honour Rollers',   'slug' => 'wolverhamption-honour-rollers',  'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 56, 'name' => 'Wrexham Rejects',                'slug' => 'wrexham-rejects',                'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 57, 'name' => 'Nottingham Roller Derby',        'slug' => 'nottingham-roller-derby',        'created_at' => new DateTime, 'updated_at' => new DateTime],
    );

    // Uncomment the below to run the seeder
    DB::table('leagues')->insert( $leagues );
  }

}
