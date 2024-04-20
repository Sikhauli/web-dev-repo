
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
                showToastMessage('Failed to update TODO item');
            }
            return response.json();
        })
        .then(updatedTodo => {
            showToastMessage('TODO item updated:');
        })
        .catch(error => {
            console.error('Error updating TODO item:', error);
            showToastMessage('Failed to update TODO item...');
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
                console.error('Error creating new TODO item:', response);
            }
            return response.json();
        })
        .then(newTodo => {
            showToastMessage('New TODO item created');
        })
        .catch(error => {
            console.error('Error creating new TODO item:', error);
            showToastMessage('Failed to create new TODO item...', error);
        });
}

function deleteTodo(todo) {
    fetch(window.location.href + 'api/todo/' + todo.id, {
        method: 'DELETE',
    })
        .then(response => {
            if (!response.ok) {
                showToastMessage('Failed to delete TODO item');
            }
            showToastMessage('TODO item deleted');
        })
        .catch(error => {
            console.error('Error deleting TODO item:', error);
            showToastMessage('Failed to delete TODO item...');
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