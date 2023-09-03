$(document).ready(function () {
    // Función para eliminar un usuario y actualizar la tabla en tiempo real
    $(".eliminar-usuario").click(function () {
        var idUsuario = $(this).data("id");

        // Realizar una solicitud AJAX para eliminar el usuario
        $.ajax({
            type: "POST",
            url: "../php/eliminar_usuario.php",
            data: { id: idUsuario },
            success: function (response) {
                if (response === "success") {
                    // Eliminación exitosa, actualizar la tabla
                    actualizarTabla();
                } else {
                    alert("Error al eliminar el usuario.");
                }
            },
        });
    });

    // Función para actualizar la tabla
    function actualizarTabla() {
        $.ajax({
            type: "GET",
            url: "actualizar_tabla.php", // Crea este archivo para obtener los datos actualizados
            success: function (data) {
                $("#tabla-usuarios").html(data);
            },
        });
    }
});
