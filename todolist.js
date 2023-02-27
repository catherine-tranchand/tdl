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


async function deleteTaskById(taskId) {
    console.log('deleted task by id = ', taskId);

    if (confirm("Are you sure?") == true) {

        console.log('deleted task by id = ', taskId);
    
        let response = await fetch('api/tdl_delete_task.php?id='+ taskId);
        let deleteRes = await response.json();
    
        let taskEl = document.querySelector(`.todo-data[data-task-id="${taskId}"]`);
    
        if (deleteRes.success == "yes") {
            taskEl.remove();
        }
    
        console.log(taskEl);
        console.log(deleteRes);
    }

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

async function addTaskWithTodolistId(todolistId) {
    // get the todolist element with 'todolistId'
    let taskDescEl = document.querySelector(`.task-description[data-todolist-id='${todolistId}']`);

    let taskValue = taskDescEl.value;

    let response = await fetch(`api/tdl_add_task.php?todolist_id=${todolistId}&description=${taskValue}`);

    let taskRes = await response.json();

    if (taskRes.success == "yes"){
        let taskData = taskRes.data; 

        let todolistContentEl = document.querySelector(`.todo-list[data-id='${todolistId}'] .content`);

        todolistContentEl.insertAdjacentHTML('beforeend', getTaskHTML(taskData));
        todolistContentEl.scrollTop = todolistContentEl.scrollHeight;

        taskDescEl.value = '';
    }

    // get description from todolistEl
};

async function completeTaskById(taskId){
    console.log('Task is compleded', taskId);
    
    let response = await fetch ('api/tdl_complete_task.php?=id'+ taskId);
    let completeRes = await response.json();
}

function handleDescKeyup(event) {
    if (!event) { return }

    // console.log(event.target);
    let todolistId = event.target.dataset.todolistId;

    if (event.key === "Enter" || event.keyCode === 13) {
        addTaskWithTodolistId(todolistId);
    }

    console.log("Key code is " + event.keyCode);
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
                <input data-todolist-id="${data.id}" class="task-description" type="text" placeholder="What do you want to do?" onKeyUp="handleDescKeyup()">
                <button onclick="addTaskWithTodolistId(${data.id})">Add</button>
            </div>
        </li>`;
}




async function getAllTodoLists() {

    let response = await fetch('api/tdl_fetch_all.php');
    let allTodoLists = await response.json();

    let todoListContainerEl = document.querySelector('.todo-list-container');

    if (allTodoLists.success == "yes") {

        console.log(allTodoLists);

        allTodoLists.data.forEach(function(todolistData){

            todoListContainerEl.insertAdjacentHTML('beforeend', getTodolistHTML(todolistData, todolistData.tasks));

            // select the task description element
            let taskDescEl = document.querySelector(`.task-description[data-todolist-id='${todolistData.id}']`);
            taskDescEl.addEventListener('keyup', handleDescKeyup);

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