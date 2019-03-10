
 var objeto =  {
        "name" : "iphone 7 Plus",
        "capacidad" : {
            "32GB" : [{ "color": "Space Gray",
                       "precio": 12999},
                    {"color": "Rose Gold",
                       "precio": 15999},
                    ]
        }
    };

console.dir(objeto.capacidad['32GB'][0].precio);