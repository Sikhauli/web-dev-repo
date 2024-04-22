
function putTodo(todo) {
    fetch(window.location.href + 'api/todo/' + todo.id, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(todo),
    })
        .then(response => {
            if (!response.ok) {
                showToastMessage('Failed to update Todo item');
            }
            return response.json();
        })
        .then(updatedTodo => {
            showToastMessage('Todo item updated');
        })
        .catch(error => {
            console.error('Error updating Todo item:', error);
            showToastMessage('Failed to update Todo item...');
        });
}

function postTodo(todo) {
    fetch(window.location.href + 'api/todo', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(todo),
    })
        .then(response => {
            if (!response.ok) {
                console.error('Error creating new Todo item:', response);
            }
            return response.json();
        })
        .then(newTodo => {
            showToastMessage('New Todo item created');
        })
        .catch(error => {
            console.error('Error creating new Todo item:', error);
            showToastMessage('Failed to create new Todo item...', error);
        });
}

function deleteTodo(todo) {
    fetch(window.location.href + 'api/todo/' + todo.id, {
        method: 'DELETE',
    })
        .then(response => {
            if (!response.ok) {
                showToastMessage('Failed to delete Todo item');
            }
            showToastMessage('Todo item deleted');
        })
        .catch(error => {
            console.error('Error deleting Todo item:', error);
            showToastMessage('Failed to delete Todo item...');
        });
}

// example using the FETCH API to do a GET request
function getTodos() {
    fetch(window.location.href + 'api/todo')
    .then(response => response.json())
    .then(json => drawTodos(json))
    .catch(error => showToastMessage('Failed to retrieve todos...'));
}

getTodos();