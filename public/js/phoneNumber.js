(function (global) {
    var phoneNumber = {

        init: function (url) {
            var self = this;
            self.cacheDOM();
            self.urL = url;

            $(document).ready(function () {
                self.initTable();
                self.initSelectState();
                self.initSelectCountry();
            });
        },

        cacheDOM: function () {
            this.stateSelect = $('#state');
            this.countrySelect = $('#country');
        },

        initTable: function () {
            var self = this;

            self.dataTable = $('#table').DataTable({
                "processing": true,
                "serverSide": true,
                "pagingType": "full_numbers",
                "paging" : false,
                "info" : false,
                "searching": false,
                "pageLength": 100,
                "sort": false,
                "ajax": {
                    "url": self.urL,
                    "type": "POST",
                    "data": function (d) {
                        d.selectedState = self.stateSelect.val();
                        d.selectedCountry = self.countrySelect.val();
                    }
                },
                "columns": [
                    {"data": "countryName"},
                    {"data": "state"},
                    {"data": "countryCode"},
                    {"data": "number"}
                ],
                "columnDefs": [
                    {
                        "render": function (data, type, row) {
                            return data === '1' ? 'OK' : 'NOK'
                        },
                        "targets": 1
                    },
                    {
                        "render": function (data, type, row) {
                            return '+' + data;
                        },
                        "targets": 2
                    }

                ],
            });

        },

        initSelectState: function () {
            var self = this;

            self.stateSelect.change(function () {
                self.dataTable.ajax.reload();
            });
        },

        initSelectCountry: function () {
            var self = this;
            self.countrySelect.change(function () {
                self.dataTable.ajax.reload();
            });
        },
    };

    if (typeof define === 'function' && define.amd) {
        define(phoneNumber);
    } else if (typeof exports === 'object') {
        module.exports = phoneNumber;
    } else {
        window.phoneNumber = phoneNumber;
    }

})(window);
