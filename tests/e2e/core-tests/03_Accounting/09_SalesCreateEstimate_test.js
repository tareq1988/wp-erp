const helpers = require('../../pages/helpers');
Feature('Sales');

Scenario('@Sales createEstimate',({ I, loginAs }) => {
    loginAs('admin');
        helpers.accDashboard();
        helpers.previewTransactions();
        helpers.sales();
        helpers.createEstimate();
});
