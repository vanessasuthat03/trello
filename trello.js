const draggables = document.querySelectorAll(".draggable")
const containers = document.querySelectorAll(".container")
const firstTasks = document.querySelectorAll(".firstTask")

draggables.forEach(draggable => {
  draggable.addEventListener("dragstart", () => {
    // console.log("drad start")
    // console.log("status_id",draggable.value)
    draggable.classList.add("dragging")
    // console.log("dragged element",draggable)
    // console.log("parent to dragged element",draggable.parentElement.firstElementChild.value)
  })

  draggable.addEventListener("dragend", () => {
    let toContainer_id = parseInt(
      draggable.parentElement.firstElementChild.value
    )
    let task_id = draggable.value
    let fromContainer_id = parseInt(draggable.firstElementChild.value)
    // console.log(task_id)
    // console.log('drag stop')

    // console.log("task_id",draggable.value)
    draggable.classList.remove("dragging")

    if (fromContainer_id !== toContainer_id) {
      //   console.log('task_id i if', task_id)
      //   console.log('tasken tas från container', fromContainer_id)
      //   console.log('tasken stoppar in i container',  toContainer_id)

      const toSend = {
        task_id: task_id,
        toContainer_id: toContainer_id,
        fromContainer_id: fromContainer_id
      }

      const jsonString = JSON.stringify(toSend)
      const xhr = new XMLHttpRequest()

      xhr.open("POST", `update.php?task_id=${task_id}`)
      xhr.setRequestHeader("Content-Type", "application/json")
      xhr.send(jsonString)
    } else {
      console.log("hej")
    }
  })
})

containers.forEach(container => {
  container.addEventListener("dragover", e => {
    //    console.log("dragg over")
    e.preventDefault()
    const afterElement = getDragAfterElement(container, e.clientY)
    // console.log(container)
    const draggable = document.querySelector(".dragging")
    // console.log(draggable.value)

    if (afterElement == null) {
      // console.log("afterElement == null")
      //    console.log(draggable.value)
      $task_id = draggable.value
      // console.log($task_id)
      container.appendChild(draggable)

      //   console.log(container.firstElementChild.value)
      $container_id = container.firstElementChild.value
      // console.log($container_id)
      $task_id == $container_id
      // console.log($task_id)
      let task = document.getElementsByClassName("idStatus")

      // if(task===$task_id)
      // console.log(task)
    } else {
      container.insertBefore(draggable, afterElement)
      // console.log('????', container.firstElementChild.value)
      // console.log(afterElement)
    }
  })
})

//test
firstTasks.forEach(firstTask => {
  firstTask.addEventListener("dragover", e => {
    e.preventDefault()
    const afterElement = getDragAfterElement(firstTask, e.clientY)
    // console.log(container)
    const draggable = document.querySelector(".dragging")
    // console.log(draggable.value)

    if (afterElement == null) {
      //    console.log(draggable.value)
      $task_id = draggable.value
      // console.log($task_id)
      firstTask.appendChild(draggable)
      //   console.log(container.firstElementChild.value)
      $container_id = firstTask.firstElementChild.value
      // console.log($container_id)
      $task_id == $container_id
      // console.log($task_id)
      let task = document.getElementsByClassName("idStatus")

      // if(task===$task_id)
      // console.log(task)
    }
  })
})

function getDragAfterElement(container, y) {
  const draggableElements = [
    ...container.querySelectorAll(".draggable:not(.dragging)")
  ]

  return draggableElements.reduce(
    (closest, child) => {
      const box = child.getBoundingClientRect()
      const offset = y - box.top - box.height / 2
      if (offset < 0 && offset > closest.offset) {
        return {
          offset: offset,
          element: child
        }
      } else {
        return closest
      }
    },
    {
      offset: Number.NEGATIVE_INFINITY
    }
  ).element
}

//test
for (let i = 0; i < 3; i++) {
  let toggle = document.getElementsByClassName("toggle")
  let hide = document.getElementsByClassName("formInput")
  toggle[i].addEventListener("click", function() {
    hide[i].style.display = (hide[i].dataset.toggled ^= 1) ? "block" : "none"
  })
}

const inputs = document.querySelectorAll(".addNewTitle")
const validateInput = event => {
  let inputId = event.target.id.match(/\d+/g).map(Number)[0]
  const errorOutputs = document.querySelectorAll(".errorMessage")
  const addNewTaskInputs = document.querySelectorAll(".formInput")

  console.log("length", event.target.value.length)

  for (addNewTaskInput of addNewTaskInputs) {
    let taskStatusId = addNewTaskInput.dataset.index
      .match(/\d+/g)
      .map(Number)[0]
    if (taskStatusId === inputId) {
      for (errorOutput of errorOutputs) {
        if (parseInt(errorOutput.id) === inputId && event.target.value <= 0) {
          console.log("error bör visas")
          errorOutput.style.display = "block"
        } else {
          console.log("error bör inte visas")
          errorOutput.style.display = "none"
        }
      }
    }
  }
}

for (input of inputs) {
  console.log("det går")
  input.addEventListener("input", validateInput)
}

let updateBtn = document.querySelectorAll(".updateBtn")
let modal = document.querySelectorAll(".bg_modal")
let close = document.querySelectorAll(".close")

updateBtn.forEach((btn, index) => {
  btn.addEventListener("click", () => {
    console.log("btn value: ", btn.attributes[3].value)
    console.log("btn parent value: ", btn.parentElement.attributes[2].value)

    modal.forEach(mod => {
      if (parseInt(btn.attributes[3].value) === parseInt(mod.id)) {
        mod.style.display = "flex"
      }
    })

    close.forEach(clo => {
      if (parseInt(btn.attributes[3].value) === parseInt(clo.id)) {
        clo.addEventListener("click", () => {
          modal.forEach(mod => {
            if (parseInt(btn.attributes[3].value) === parseInt(mod.id)) {
              mod.style.display = "none"
            }
          })
        })
      }
    })
  })
})

let deleteBtn = document.querySelectorAll(".deleteBtn")
let modalDelete = document.querySelectorAll(".bg_modal_delete")
let closeDelete = document.querySelectorAll(".closeDelete")

deleteBtn.forEach((btn, index) => {
  btn.addEventListener("click", () => {
    modalDelete.forEach(modal => {
      if (parseInt(btn.attributes[3].value) === parseInt(modal.id)) {
        modal.style.display = "flex"
      }
    })

    closeDelete.forEach(close => {
      if (parseInt(btn.attributes[3].value) === parseInt(close.id)) {
        close.addEventListener("click", () => {
          modalDelete.forEach(modal => {
            modal.style.display = "none"
            if (parseInt(btn.attributes[3].value) === parseInt(modal.id)) {
              modal.style.display = "none"
            }
          })
        })
      }
    })
  })
})
