window.sgConfirm = (title, msg, button, success, type) =>
{
  Swal.fire({
    title: title,
    html: msg,
    icon: type == null ? 'info' : type,
    showCancelButton: true,
    confirmButtonText: button == null ? 'Aceptar' : button,
  }).then(function(result){
    if (result.value) {
      success();
    }
  });
};

window.asyncForEach = async function (array, callback) {
  for (let index = 0; index < array.length; index++) {
    await callback(array[index], index, array);
  }
};

window.asyncMap = async function (array, callback) {
  let newArray = [];
  for (let index = 0; index < array.length; index++) {
    newArray[index] = await callback(array[index], index, array);
  }
  return newArray;
};
