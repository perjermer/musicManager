function validate(form)
      {
        fail  = validateName(form.name.value)

        if (fail == "")     return true
        else { alert(fail); return false }
      }

      function validateName(field)
      {
        return (field == "") ? "No artist was entered.\n" : ""
      }
