// Подключаем модуль 'marcrecord'.
var marcrecord = require('marcrecord');
// Создаем объект для чтения записей из файла ISO2709 и открываем файл записей.
var marcReader = new marcrecord.MarcIsoReader();
marcReader.openSync('records.iso');
// Читаем записи из файла ISO2708.
while (record = marcReader.nextSync()) {
    // Получаем первое поле с тегом '856'.
    var field = record.getVariableField('856');
        if (field) {
        // Получаем в поле '856' первое подполе с кодом 'u'.
        var subfield = field.getSubfield('u');
        // Проверяем содержимое подполя.
            if (subfield) { //&& subfield.data === 'The Oxford Russian minidictionary'
            console.log('Found the 856 field.');
            break;
        }
    }
}
// Завершаем работу с объектом для чтения записей ISO2709.
marcReader.closeSync();