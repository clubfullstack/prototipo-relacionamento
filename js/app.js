// app.js

// Simular carregamento de dados
const fetchData = async () => {
  const response = await fetch('data.json');
  return response.json();
};

// Função para realizar a busca
const searchServices = async () => {
  const query = document.getElementById('searchInput').value.toLowerCase();
  const resultsContainer = document.getElementById('results');
  resultsContainer.innerHTML = ''; // Limpar resultados anteriores

  // Obter dados simulados
  const data = await fetchData();
  const filteredResults = data.filter(item =>
    item.specialty.toLowerCase().includes(query)
  );

  // Exibir resultados
  if (filteredResults.length > 0) {
    document.getElementById('resultsSection').style.display = 'block';
    filteredResults.forEach(item => {
      resultsContainer.innerHTML += `
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">${item.name}</h5>
              <p class="card-text">Especialidade: ${item.specialty}</p>
              <p class="card-text">Localização: ${item.location}</p>
              <p class="card-text">Aceita: ${item.paymentOptions.join(', ')}</p>
              <button class="btn btn-primary">Solicitar Serviço</button>
            </div>
          </div>
        </div>`;
    });
  } else {
    resultsContainer.innerHTML = '<p>Nenhum resultado encontrado.</p>';
  }
};
