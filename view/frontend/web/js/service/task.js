define([
  'mage/storage'
], function (storage) {
  'use strict';
  
  return {
    getList: async function () {
      return await storage.get('rest/V1/customer/me/todo/tasks')
    },
  
    save: async function(task) {
      return await storage.post(
        'rest/V1/customer/me/todo/tasks/create',
        JSON.stringify({
          task: task
        })
      )
    },
    
    update: async function(taskId, status) {
      return await storage.post(
        'rest/V1/customer/me/todo/tasks/update',
        JSON.stringify({
          taskId: taskId,
          status: status
        })
      );
    },
  
    completeAll: async function() {
      return await storage.post('rest/V1/customer/me/todo/tasks/completeAll');
    },
    
    delete: async function(task) {
      return await storage.post(
        'rest/V1/customer/me/todo/tasks/delete',
        JSON.stringify({
          task: task
        })
      )
    },
  
    deleteAll: async function() {
      return await storage.post('rest/V1/customer/me/todo/tasks/deleteAll')
    },
  
    deleteCompleted: async function() {
      return await storage.post('rest/V1/customer/me/todo/tasks/deleteCompleted')
    }
  }
})