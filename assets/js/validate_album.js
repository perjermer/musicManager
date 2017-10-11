function validate(form)
      {
        fail  = validateName(form.name.value)
        fail += validateArtist(form.artist.value)
        fail += validateGenre(form.genre.value)
        fail += validatePrice(form.price.value)

        if (fail == "")     return true
        else { alert(fail); return false }
      }

      function validateName(field)
      {
        return (field == "") ? "No album was entered.\n" : ""
      }

      function validateArtist(field)
      {
        return (field == "na") ? "No artist was selected.\n" : ""
      }

      function validateGenre(field)
      {
        return (field == "na") ? "No genre was selected.\n" : ""
      }

      function validatePrice(field)
      {
        if (isNaN(field)) return "Invalid price.\n"
        else if (field=="") return "No price was entered.\n"
        else return ""
      }
