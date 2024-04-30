define([
  'uiElement',
  'jquery',
  'mage/translate',
  'Magento_Ui/js/modal/confirm',
  'Magento_Ui/js/modal/alert',
  'VPT_Todo/js/service/task',
  'VPT_Todo/js/model/loader'
], function (Component, $, $t, confirm, alert, taskService, loader) {
  'use strict'
  
  return Component.extend({
    defaults: {
      tasks: [],
      inputData: '',
      tasksAmount: false,
      listens: {
        tasks: 'onTasksChange'
      }
    },
  
    initObservable: function () {
      this._super().observe(['tasks', 'inputData', 'tasksAmount']);
  
      let self = this;
      
      taskService.getList()
        .then(function (tasks) {
          self.set('tasks', tasks);
      
          // It's a promise, and would allow us to add more than function or callbacks for getList method
          return tasks;
        })
      
      return this;
    },
  
    taskId: function () {
      const date = new Date();
    
      return date.getTime();
    },
    
    addNewTask: function () {
      let self = this;
      
      if (self.inputData() !== '') {
        let tasksOldVal = self.inputData(),
          task = {
          label: self.inputData(),
          status: 'open'
        };
  
        self.inputData('');
        loader.startLoader();
  
        taskService.save(task)
          .then(function (taskId) {
            task.task_id = taskId;
            
            self.tasks.push(task);
          })
          .catch(function () {
            self.inputData(tasksOldVal);
          })
          .finally(function () {
            loader.stopLoader();
          })
      }
    },
  
    checkIsEnter: function (data, event) {
      if (event.keyCode === 13) {
        event.preventDefault();
      
        this.addNewTask();
      }
    },
  
    deleteAll: function () {
      let self = this;
      
      confirm({
        content: $t('Are you sure you want to delete all task?'),
        actions: {
          confirm: function () {
            taskService.deleteAll();
            
            self.set('tasks', []);
          }
        }
      })
    },
  
    deleteCompleted: function () {
      let tasks = [],
        isCompleted = false,
        self = this;
  
      for (let i = 0; i < self.tasks().length; i++) {
        if (self.tasks()[i].status !== 'complete') {
          tasks.push(self.tasks()[i]);
        } else {
          isCompleted = true;
        }
      }
      
      if (isCompleted) {
        confirm({
          content: $t('Are you sure you want to delete selected the task?'),
          actions: {
            confirm: function () {
              taskService.deleteCompleted();
              
              self.set('tasks', tasks);
            }
          }
        })
      } else {
        alert({
          content: $t('You haven\'t completed any tasks.')
        })
      }
    },
  
    completeAll: function (){
      let tasks = [],
        self = this;
      
      confirm({
        content: $t('Are you sure you want to complete all tasks?'),
        actions: {
          confirm: function () {
            for (let i = 0; i < self.tasks().length; i++) {
              self.tasks()[i].status = 'complete';
              
              tasks.push(self.tasks()[i]);
            }
  
            loader.startLoader();
            
            taskService.completeAll()
              .then(function () {
                self.set('tasks', tasks);
              })
              .finally(function () {
                loader.stopLoader();
              });
          }
        }
      })
    },
  
    onTasksChange: function (data) {
      (data.length > 0) ? this.tasksAmount(true) : this.tasksAmount(false);
    }
  })
})