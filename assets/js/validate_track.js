function validate(form)
      {
        fail  = validateName(form.name.value)
        fail += validateAlbum(form.CD.value)
        fail += validateLength(form.length.value)

        if (fail == "")     return true
        else { alert(fail); return false }
      }

      function validateName(field)
      {
        return (field == "") ? "No track was entered.\n" : ""
      }

      function validateAlbum(field)
      {
        return (field == "0") ? "No album was selected.\n" : ""
      }

      function validateLength(field)
      {
        if (isNaN(field)) return "Invalid duration.\n"
        else if (field=="") return "No duration was entered.\n"
        else return ""
      }
