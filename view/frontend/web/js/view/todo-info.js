define([
  'uiElement'
], function (Component) {
  'use strict'
  
  return Component.extend({
    defaults: {
      tracks: {
        tasks: true,
        tasksAmount: true
      },
      links: {
        tasks: '${ $.provider }:tasks',
        tasksAmount: '${ $.provider }:tasksAmount'
      },
      listens: {
        tasks: 'completedTasksAmount'
      }
    },
  
    completedTasksAmount: function () {
      let tasks = 0;
      
      if (this.tasks.length > 0) {
        for (let i = 0; i < this.tasks.length; i++) {
          if (this.tasks[i].status === 'complete') {
            tasks += 1;
          }
        }
      }
      return tasks;
    },
  
    uncompletedTasksAmount: function () {
      let tasks = 0;
    
      if (this.tasks.length > 0) {
        for (let i = 0; i < this.tasks.length; i++) {
          if (this.tasks[i].status !== 'complete') {
            tasks += 1;
          }
        }
      }
      return tasks;
    }
  })
})