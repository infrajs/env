import { Env } from "/vendor/infrajs/env/Env.js"
import { Template } from '/vendor/infrajs/template/Template.js'

Template.scope['Env'] = { 
    get: prop => Env.get(prop),
    getName: () => Env.getName()
}
