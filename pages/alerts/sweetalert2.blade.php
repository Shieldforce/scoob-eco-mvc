<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    function loadingScoob(
        title = 'Sem título',
        html = "<span>Sem descrição</span>",
        timer = null,
    ) {
        Swal.fire({
            title: title,
            html: html,
            timer: timer,
            timerProgressBar: true,
            theme: localStorage.getItem("theme") || "light",
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }

    function successScoob(
        title = 'Sem título',
        html = "<span>Sem descrição</span>",
        buttonOk = false,
    ) {
        var obj = {
            title: title,
            html: html,
            theme: localStorage.getItem("theme") || "light",
            icon: "success",
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Confirmar!',
        };

        if (!buttonOk) {
            obj.timer = 5000;
            obj.timerProgressBar = true;
        }

        Swal.fire(obj);
    }

    function errorScoob(
        title = 'Sem título',
        html = "<span>Sem descrição</span>",
        buttonOk = false,
    ) {
        var obj = {
            title: title,
            html: html,
            theme: localStorage.getItem("theme") || "light",
            icon: "error",
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Confirmar!',
        };

        if (!buttonOk) {
            obj.timer = 5000;
            obj.timerProgressBar = true;
        }

        Swal.fire(obj);
    }

</script>
