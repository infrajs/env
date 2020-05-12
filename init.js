import { Env } from "/vendor/infrajs/env/Env.js"
import { Template } from '/vendor/infrajs/template/Template.js'

Template.scope['Env'] = {};
Template.scope['Env']['get'] = function (name) { return Env.get(name) };
Template.scope['Env']['name'] = function () { return Env.name(); };
Template.scope['Env']['is'] = function () { return Env.is(); };
