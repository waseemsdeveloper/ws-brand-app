/*
* Company : Dropskit
* email : support@dropskit.com
*/

window.onload = () => {

    var overlay = document.getElementById('overlay');

    function set_notifications(type, status, msg) {
        const OBJ = {
            'status': status,
            'msg': msg
        }

        localStorage.setItem(type, JSON.stringify(OBJ));

    }

    function create_new_brand() {
        const inp = document.getElementsByName('brand_name');

        if (!inp[0].value) {
            document.getElementById('status').innerHTML = `<div class="alert alert-danger" role="alert">${'Please provide a brand name!'}</div>`;
        } else {

            const request = new XMLHttpRequest();

            request.addEventListener('load', (response) => {
                //    alert(response.currentTarget.responseText);
                //  location.reload();
                let msg = JSON.parse(response.currentTarget.responseText);
                // console.log(msg);
                if (msg.status == 'error') {
                    document.getElementById('status').innerHTML = `<div class="alert alert-danger" role="alert">${msg.msg}</div>`;
                } else if (msg.status == 'success') {

                    set_notifications('notification', msg.status, msg.msg);

                    const tb = document.getElementById('tableBody');

                    var row = tb.insertRow(0);
                    var cell1 = row.insertCell(0);
                    var cell2 = row.insertCell(1);

                    cell1.className = 'text-center';
                    cell1.innerHTML = `<input type="checkbox" name="names" id="${msg.last_id}">`;
                    cell2.innerHTML = `
                   ${inp[0].value}
                   <div class="float-right text-danger" <a class="m-3 pr-5  "><i class="fas fa-trash trashThis" id="${msg.last_id}" name="trash"></i></a></div>
                    `;
                }
            });
 
            request.open('POST', 'add.php');
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(`add=true&data=${inp[0].value}`);
        }
    }

    function delete_brand(action, data) {
        if (data.length == 0) {
            // console.log(data);
            document.getElementById('status').innerHTML = `<div class="alert alert-danger" role="alert">${'Please select at leasr 2 brands to delete'}</div>`;
        }
        // console.log(data);
        const request = new XMLHttpRequest();

        request.addEventListener('load', (response) => {
            //  console.log(response.currentTarget.responseText);
            let msg = JSON.parse(response.currentTarget.responseText);
            if (msg.status == 'error') {
                document.getElementById('status').innerHTML = `<div class="alert alert-danger" role="alert">${msg.msg}</div>`;
            } else if (msg.status == 'success') {
                set_notifications('delete_notification', msg.staus, msg.msg);
                location.reload();
            }
        });

        request.open('POST', 'functions/delete_function.php');
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send(`action=${action}&data=${data}`);

    }

    function export_to_csv(action, data) {

        const request = new XMLHttpRequest();

        request.addEventListener('load', (response) => {
            // console.log(response.currentTarget.responseText);
            csv_file_generator(response.currentTarget.responseText);
        });

        request.open('POST', 'functions/csv_exporter.php');
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send(`action=${action}&data=${data}`);
    }

    function get_selected_brands(current) {
        return new Promise((resolve) => {

            const inp = document.getElementsByName('names');
            const data = [];

            if (current == 'current') {
                for (let i = 0; i < inp.length; i++) {
                    data.push(inp[i].value);
                }
                resolve(data);
            } else {
                for (let i = 0; i < inp.length; i++) {
                    if (inp[i].checked == true) {
                        data.push(inp[i].value);
                    }
                }
                //  console.log(data);
                resolve(data);
            }
        });
    }

    function csv_file_generator(data) {

        const csv_data = data.split(',');
        //   const csv = [];
        const csv_string = csv_data.join('\n');
        console.log('from server');
        console.log(csv_data);
        //   console.log(csv_data);

        var filename = 'export_brand_names' + '.csv';
        var link = document.createElement('a');
        link.style.display = 'none';
        link.setAttribute('target', '_blank');
        link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv_string));
        link.setAttribute('download', filename);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

    }

    function check_all(ch) {
        const inp = document.getElementsByName('names');
        if (ch === true) {
            for (let i = 0; i < inp.length; i++) {
                inp[i].checked = true;
            }
        } else {
            for (let i = 0; i < inp.length; i++) {

                inp[i].checked = false;
            }
        }
    }

    function refresh() {

        overlay.style.display = 'block';

        let request = new XMLHttpRequest();
        request.open('GET', 'process.php?data=load', true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.addEventListener('load', (response) => {
            // console.log(response.target.response);
            if (response.currentTarget.readyState === 4 || response.currentTarget.status === 200) {
                //  console.log(response.currentTarget);
                var brands = JSON.parse(response.currentTarget.responseText);
                const brand = brands.map((data) => {
                    var obj = {
                        id: data.id,
                        name: data.brand_name
                    }
                    return obj;
                }); // array map
                //  console.log(brand[0].name)
                for (x in brands) {
                    const tb = document.getElementById('tableBody');
                    var row = tb.insertRow();
                    var cell1 = row.insertCell(0);
                    var cell2 = row.insertCell(1);
                  

                    cell1.className = 'text-center';
                    cell1.innerHTML = `<input type="checkbox" name="names" value="${brand[x].id}" id="">`;
                    cell2.innerHTML = `
                    ${brand[x].name} 
                   <div class="float-right text-danger" <a class="m-3 pr-5  "><i class="fas fa-trash trashThis" id="${brand[x].id}" name="trash"></i></a></div>
                    `;
                } // for
                checking_it();
                
                overlay.style.display = 'none';
            } // if 
        }); // event

        request.send();
    } // func

    refresh(); // this function must call before below function

    function checking_it() {
        //   console.log('asa');
        $('#datatable').DataTable();
    }

    function upload_csv_validate() {
        return new Promise((resolve) => {
            console.log('fun');
            const f = document.getElementById('inputGroupFile04').files[0];

            //  var f = evt.target.files[0];
            if (f) {

                var r = new FileReader();
                r.onload = function (e) {
                    const arr = [];
                    var contents = e.target.result;
                    //  document.write("File Uploaded! <br />" + "name: " + f.name + "<br />" + "content: " + contents + "<br />" + "type: " + f.type + "<br />" + "size: " + f.size + " bytes <br />");

                    var lines = contents.split("\n");
                    for (var i = 0; i < lines.length; i++) {
                        //  console.log(lines[i]);
                        arr.push(String(lines[i]));
                        // output.push("<tr><td>" + lines[i].split(",").join("</td><td>") + "</td></tr>");
                    }
                    /* output = "<table>" + output.join("") + "</table>";
                    document.write(output); */
                    resolve(arr);
                }
                //  console.log(arr);
                r.readAsText(f);
                //  console.log(arr);
                // document.write(output); console.log(arr);


            } else {
                alert("Failed to load file");
            }

        });


    }

    function upload_csv() {
        overlay.style.display = 'block';
        upload_csv_validate()
            .then(resp => {
                const request = new XMLHttpRequest();

                request.addEventListener('load', (response) => {
                    console.log(response.currentTarget.responseText);
                    let msg = JSON.parse(response.currentTarget.responseText);
                    if (msg.status == 'error') {
                        document.getElementById('status').innerHTML = `<div class="alert alert-danger" role="alert">${msg.msg}</div>`;
                    } else if (msg.status == 'success') {
                        set_notifications('import_notification', msg.staus, msg.msg);
                        overlay.style.display = 'none';
                        location.reload();
                    }
                });

                request.open('POST', 'functions/csv_importer.php');
                request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                request.send(`data=${resp}`);
            })
            .catch(err => {
                console.log(err);
            });
    }
    document.addEventListener('click', (e) => {
        // console.log(e.target.classList[2]);
        switch (e.target.id) {
            case 'uploadCsv':
                upload_csv();
                break;
            case 'addNewBrand':
                create_new_brand();
                break;

            case 'exportSelected':
                get_selected_brands().then((response) => {
                    export_to_csv('exportToSelected', response);
                });
                break;

            case 'exportCurrent':
                // arg current is used to get current page checkbox
                get_selected_brands('current').then((response) => {
                    export_to_csv('exportToCurrent', response);
                });
                break;

            case 'exportAll':
                export_to_csv('exportToAll');
                break;

            case 'deleteSelected':
                get_selected_brands().then((response) => {
                    delete_brand('deleteSelected', response);
                });
                break;

            case 'deleteAll':
                get_selected_brands().then((response) => {
                    delete_brand('deleteAll', response);
                });
                break;

            case 'selectAll':
                check_all(e.target.checked);
                break;

            default:
                return;
        }
    });

    document.addEventListener('keyup', (e) => {
        if (e.keyCode == 13) {
            create_new_brand();
        } else {

            const inp = document.getElementsByName('brand_name')[0].value;

            if (inp == '') {
                document.getElementById('status').innerHTML = `<div class="alert alert-danger" role="alert">${'Please provide a Brand name. . .'}</div>`;
            } else {

                let request = new XMLHttpRequest();

                request.open('GET', `check_list.php?q=${inp}`, true);
                request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                request.addEventListener('load', (response) => {
                    var msg = JSON.parse(response.currentTarget.responseText);
                    if (msg.status == 'error') {
                        document.getElementById('status').innerHTML = `<div class="alert alert-danger" role="alert">${msg.msg}</div>`;
                    } else if (msg.status == 'success') {
                        document.getElementById('status').innerHTML = `<div class="alert alert-success" role="alert">${msg.msg}</div>`;
                    }
                }); // event

                request.send();
            }


        }
    });

    document.addEventListener('click', (e) => {
        const el = e.target.localName;

        if (el == 'i') {
            const r = confirm('Do you want to delete this brand ?');

            if (r == true) {
                const request = new XMLHttpRequest();

                request.addEventListener('load', (response) => {
                    //   console.log(response.currentTarget.responseText);
                    if (response) {
                        alert(response.currentTarget.responseText);
                        e.path[3].remove();
                    }
                });

                request.open('POST', 'functions/delete.php');
                request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                request.send(`action=${'delete'}&data=${e.target.id}`);
            }

        }
    });

    var crt = JSON.parse(localStorage.getItem('notification'));
    var del = JSON.parse(localStorage.getItem('delete_notification'));
    var imp = JSON.parse(localStorage.getItem('import_notification'));

    if (crt) {
        document.getElementById('status').innerHTML = `<div class="alert alert-success" role="alert">${crt.msg}</div>`;
        setTimeout(() => {
            localStorage.removeItem('notification');
        }, 2000)
    } else if (del) {
        document.getElementById('status').innerHTML = `<div class="alert alert-success" role="alert">${del.msg}</div>`;
        setTimeout(() => {
            localStorage.removeItem('delete_notification');
        }, 2000)
    } else if (imp) {
        document.getElementById('status').innerHTML = `<div class="alert alert-success" role="alert">${imp.msg}</div>`;
        setTimeout(() => {
            localStorage.removeItem('import_notification');
        }, 2000)
    }
}