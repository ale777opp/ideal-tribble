<?php
// new record
$request = [
  "data" => [
    "type" => "marcrecord",
    "attributes" => [
      "leader" => "00000nai0 2200000 i 450 ",
      "fields" => [
        [
          "tag" => "100",
          "ind1" => " ",
          "ind2" => " ",
          "subfields" => [
             [
              "code" => "a",
              "data" => "20210219d1997 u y0rusy0189 ca"
             ]
          ]
         ],
         [
          "tag" => "101",
          "ind1" => "0",
          "ind2" => " ",
          "subfields" => [
             [
              "code" => "a",
              "data" => "rus"
             ]
          ]
         ],
         [
          "tag" => "102",
          "ind1" => " ",
          "ind2" => " ",
          "subfields" => [
             [
              "code" => "a",
              "data" => "RU"
             ]
          ]
         ],
         [
          "tag" => "106",
          "ind1" => " ",
          "ind2" => " ",
          "subfields" => [
             [
              "code" => "a",
              "data" => "s"
             ]
          ]
         ],
         [
          "tag" => "200",
          "ind1" => "1",
          "ind2" => " ",
          "subfields" => [
             [
              "code" => "a",
              "data" => "Северные крепости"
             ]
          ]
         ],
         [
          "tag" => "230",
          "ind1" => " ",
          "ind2" => " ",
          "subfields" => [
             [
              "code" => "a",
              "data" => "сетевой ресурс"
             ],
             [
              "code" => "6",
              "data" => "тестовая запись UI API"
             ]
           ]
         ],
         [
          "tag" => "300",
          "ind1" => " ",
          "ind2" => " ",
          "subfields" => [
             [
                "code" => "a",
                "data" => "Дата обращения к ресурсу 02.10.2013"
             ]
          ]
         ],
         [
          "tag" => "801",
          "ind1" => " ",
          "ind2" => "0",
          "subfields" => [
             [
              "code" => "a",
              "data" => "RU"
             ],
             [
              "code" => "b",
              "data" => "RGBI"
             ],
             [
              "code" => "c",
              "data" => "20210219"
             ],
             [
              "code" => "g",
              "data" => "rcr"
             ]
          ]
         ],
         [
          "tag" => "801",
          "ind1" => " ",
          "ind2" => "1",
          "subfields" => [
             [
              "code" => "a",
              "data" => "RU"
             ],
             [
              "code" => "b",
              "data" => "RGBI"
             ],
             [
              "code" => "c",
              "data" => "19980713"
             ]
          ]
         ],
         [
          "tag" => "856",
          "ind1" => "4",
          "ind2" => "0",
          "subfields" => [
             [
                "code" => "u",
                "data" => "http =>//www.nortfort.ru/"
             ]
          ]
         ],
         [
          "tag" => "909",
          "ind1" => " ",
          "ind2" => " ",
          "subfields" => [
             [
                "code" => "a",
                "data" => "Сетевой ресурс"
             ]
          ]
         ]
       ]
     ]
   ]
];
// add info in field of records
$record_field = [
  "data" => [
    [
      "op" => "replace", // add,remove,replace
      "type" => "marcrecord",
      "attributes" => [
        "fields" => [
           [
            "tag" => "300",
            "ind1" => " ",
            "ind2" => " ",
            "subfields" => [
              [
                "code" =>"a",
                "data" => "Дата обращения к ресурсу 20.02.2021"
              ]
            ]
          ]
        ]
      ]
    ]
  ]
];
// remove info of field of records  300 ##$aДата обращения к ресурсу 02.10.2013

?>