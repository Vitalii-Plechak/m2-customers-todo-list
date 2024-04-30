define([
  'underscore',
  'Magento_Ui/js/grid/columns/select'
], function(_, Column) {
  'use strict';
  
  return Column.extend({
    defaults: {
      bodyTmpl: 'VPT_Todo/grid/cells/status'
    },
    
    getOrderStatusColor: function (row) {
      if (row.status !== 'open') {
        return 'status-enabled';
      } else {
        return 'status-disabled';
      }
    },
    
    getStatusLabel: function (row) {
      return row.status;
    }
  });
});