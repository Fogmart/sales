jQuery(function ($) {

    console.log('====================================');
    $(function () {
       if ($('#my_file_input').length > 0){
            oFileIn = document.getElementById('my_file_input');
            if (oFileIn.addEventListener) {
                oFileIn.addEventListener('change', filePicked, false);
            }
       }
    });

    function onlyUnique(value, index, self) {
        return self.indexOf(value) === index;
    }

    function filePicked(oEvent) {
        // Get The File From The Input
        var oFile = oEvent.target.files[0];
        // Create A File Reader HTML5
        var reader = new FileReader();

        // Ready The Event For When A File Gets Selected
        // Ready The Event For When A File Gets Selected
        reader.onload = function (e) {
            var data = e.target.result;
            var workbook = XLSX.read(data, {
                type: 'binary'
            });
            var XL_row_object;
            workbook.SheetNames.forEach(function (sheetName) {
                // Here is your object
                XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[
                    sheetName]);
                if (!window.XL_row_object){
                    window.XL_row_object = XL_row_object;
                }
                var Subjects = [];
                var newString = '';
                var secondString = '';
                XL_row_object.map(function (item) {
                    newString = '';
                    secondString = '';
                    if (item.Subjects) {
                        newString = item.Subjects.substring(3);
                        // узнаем есть ли спец символ, в нашем случае "/"
                        if (item.Subjects.indexOf('/') > -1) {
                            // берем предмет до "/"
                            secondString = newString.substring(newString.indexOf('/') + 1, newString.length);
                            // добавляем в массив предметов "предмет"
                            Subjects.push(secondString);

                            // берем предмет после "/"
                            newString = newString.substring(0, newString.indexOf('/'));

                            // добавляем в массив предметов "предмет"
                            Subjects.push(newString);
                        } else {
                            // если нет "/", добавляем в массив предметов "предмет"
                            Subjects.push(newString);
                        }
                    }
                });
                var unique = Subjects.filter(onlyUnique);
            })
        };

        // Tell JS To Start Reading The File.. You could delay this if desired
        reader.readAsBinaryString(oFile);
    }
});