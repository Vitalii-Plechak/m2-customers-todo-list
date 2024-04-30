define([
  'uiComponent'
], function (Component) {
  'use strict'
  
  return Component.extend({
    defaults: {
      tracks: {
        tasks: true,
        inputData: true,
        tasksAmount: true
      },
      links: {
        tasks: '${ $.provider }:tasks',
        inputData: '${ $.provider }:inputData',
        tasksAmount: '${ $.provider }:tasksAmount'
      }
    }
  })
});