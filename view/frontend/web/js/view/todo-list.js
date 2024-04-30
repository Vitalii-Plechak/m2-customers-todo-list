define([
  'uiElement',
  'jquery',
  'mage/translate',
  'Magento_Ui/js/modal/confirm',
  'VPT_Todo/js/service/task',
], function (Component, $, $t, confirm, taskService) {
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
  
    switchStatus: function (data, event) {
      const taskId = parseInt($(event.target).attr('data-id'));
    
      let items = this.tasks.map(function (task) {
        if (task.task_id === taskId) {
          task.status = task.status === 'open' ? 'complete' : 'open';
  
          taskService.update(taskId, task.status);
        }
      
        return task
      });
      
      this.set('tasks', items);
  
      $(event.target).siblings('.setting').addClass('hidden');
    },
  
    deleteTask: function (data, event) {
      let self = this;
    
      confirm({
        content: $t('Are you sure you want to delete the task?'),
        actions: {
          confirm: function () {
            const tasks = [],
              taskId = parseInt($(event.target).attr('data-id'));
  
            taskService.delete(self.tasks.find(function (task) {
              if (task.task_id === taskId) {
                return task;
              }
            }))
          
            if (self.tasks.length === 1) {
              self.set('tasks', tasks);
            }
          
            for (let i = 0; i < self.tasks.length; i++) {
              if (self.tasks[i].task_id !== taskId) {
                tasks.push(self.tasks[i]);
              }
            }
            
            self.set('tasks', tasks);
  
            $('.actions-wrapper').removeClass('expand');
            $('.actions-wrapper .setting').removeClass('hidden');
          }
        }
      });
    },
    
    toggleSettings: function (data, event) {
      let actionsWrapper = $('.actions-wrapper'),
        currentTarget = $(event.target);
      
      if (!currentTarget.hasClass('hidden')) {
        actionsWrapper.removeClass('expand');
        actionsWrapper.find('.setting').removeClass('hidden');
  
        currentTarget.parent().addClass('expand');
        currentTarget.addClass('hidden');
      } else {
        currentTarget.parent().removeClass('expand');
        actionsWrapper.find('.setting').removeClass('hidden');
      }
    }
  })
})