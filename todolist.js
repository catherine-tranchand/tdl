function showCompletedTodos(){
    let completedTodosSection = document.getElementById('completedTodos');
    completedTodosSection.setAttribute('opened', '');
}

function showAllTodos(){
    let completedTodosSection = document.getElementById('completedTodos');
    completedTodosSection.removeAttribute('opened');
}


async function deleteTodolistById(todolistId) {
    if (confirm("Are you sure?") == true) {

        console.log('deleted todolist by id = ', todolistId);
    
        let response = await fetch('api/tdl_delete_todolist.php?id='+ todolistId);
        let deleteRes = await response.json();
    
        let todolistEl = document.querySelector(`.todo-list[data-id="${todolistId}"]`);
    
        if (deleteRes.success == "yes") {
            todolistEl.remove();
        }
    
        console.log(todolistEl);
        console.log(deleteRes);
    }

}


async function deleteTaskById(id) {
    console.log('deleted task by id = ', id);


}


function getTaskHTML(task) {
    return `
        <li class="todo-data" data-task-id="${task.id}">
            <input type="checkbox">
            <p>${task.description}</p>
            <button class="todo-delete-btn" onclick="deleteTaskById(${task.id})"><span class="material-symbols-outlined icon">close</span></button>
        </li>
    `;
}

function getTodolistHTML(data, tasks = []) {

    let content = "";

    tasks.forEach(function(task) {
        content += getTaskHTML(task);
    });

    return `
        <li class="todo-list" data-id="${data.id}">
            <div class="bar">
                <button onclick="deleteTodolistById(${data.id})"><span class="material-symbols-outlined">delete</span></button>
                
                <div class="info">
                    <h2 class="todo-name">${data.title}</h2>
                    <h4 class="todo-date">${data.createdAt}</h4>
                </div>
            </div>
            
            <ul class="content">${content}</ul>
            
            <div class="input-container">
                <input type="text" placeholder="What do you want to do?">
                <button>Add</button>
            </div>
        </li>`;
}



async function getAllTodoLists() {

    let response = await fetch('api/tdl_fetch_all.php');
    let allTodoLists = await response.json();

    let todoListContainerEl = document.querySelector('.todo-list-container');

    if (allTodoLists.success == "yes") {

        allTodoLists.data.forEach(function(todolistData){

            todoListContainerEl.insertAdjacentHTML('beforeend', getTodolistHTML(todolistData, todolistData.tasks));

        });

    }

    
    return allTodoLists;
};

async function createTodolist(){
  

    let newListEl = document.getElementById("newList");
    let title = newListEl.value;
    let response = await fetch('api/tdl_create_todolist.php?title=' + title);
    let todolistRes = await response.json();

    if(todolistRes.success == "yes"){
        let todolistData = todolistRes.data;

        let creatorEl = document.getElementById("creator");

        creatorEl.insertAdjacentHTML('afterend', getTodolistHTML(todolistData));

        newListEl.value = "";

        

        console.log(todolistData);
    }


   
}

window.onload = async () => {

    let todoLists = await getAllTodoLists();

    console.log(todoLists);
};