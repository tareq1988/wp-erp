Feature('Payroll');

Scenario('@Payroll payrun',({ I }) => {
    I.loginAsAdmin();
        I.click('WP ERP');
        I.click('HR');
        I.moveCursorTo('//*[@id="wpbody-content"]/div[3]/ul/li[3]/a');
        I.click('Pay Calendar');
        I.click('//*[@id="dashboard-widgets-wrap"]/div/div[2]/div[2]/span[2]');
        I.wait('2');
        I.click('div:nth-of-type(1) > input:nth-of-type(1)'); // I.fillField("//div[@id='pay-run-wrapper-employees']/div/div/input", "2020-01-01")
        I.click('//*[@id="ui-datepicker-div"]/table/tbody/tr[1]/td[4]/a');
        I.click('div:nth-of-type(1) > input:nth-of-type(2)'); // I.fillField("//div[@id='pay-run-wrapper-employees']/div/div/input[2]", "2020-01-30")
        I.click('//*[@id="ui-datepicker-div"]/table/tbody/tr[3]/td[4]/a');
        I.click('div:nth-of-type(2) > .hasDatepicker'); // I.fillField("//div[@id='pay-run-wrapper-employees']/div/div[2]/input", "2020-02-01")
        I.click('//*[@id="ui-datepicker-div"]/table/tbody/tr[5]/td[5]/a');
        I.click('//*[@id="pay-run-wrapper-employees"]/div[3]/button');
        I.click('//*[@id="pay-run-wrapper-variable-input-tab"]/div[2]/div[1]/div/div[1]/select');
        I.click('//*[@id="pay-run-wrapper-variable-input-tab"]/div[2]/div[1]/div/div[1]/select/option[1]');
        I.click('//*[@id="pay-run-wrapper-variable-input-tab"]/div[2]/div[1]/div/div[1]/select');
        I.click('//*[@id="pay-run-wrapper-variable-input-tab"]/div[2]/div[1]/div/div[1]/input[1]');
        I.type('2000');
        I.click('//*[@id="pay-run-wrapper-variable-input-tab"]/div[2]/div[2]/div/a[1]');
        I.scrollPageToBottom();
        I.click('//*[@id="pay-run-wrapper-payslips-tab"]/div[2]/a[1]');
        I.click('Approve');
        I.wait('3');
        I.click('Confirm');
        I.see('Pay Run List');


});
