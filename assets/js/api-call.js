document.addEventListener('DOMContentLoaded', async () => {
  const refreshButton = document.getElementById('button-refresh-data');
  let oldData = null;

  // Fetch data from the API and parse the response.
  const fetchData = async () => {
    const response = await fetch(mp_be_test_ajax.ajax_url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams({ action: 'get_table_data' })
    });

    const { success, data: dataString } = await response.json();

    if (!success) {
      console.error('Error:', dataString);
      return null;
    }

    return JSON.parse(dataString);
  };

  // Display the fetched data in a table.
  const displayData = ({ title, data: { headers, rows } }) => {
    if (oldData && oldData === JSON.stringify({ title, data: { headers, rows } })) {
      alert('Refresh made but data didn\'t change');
    }

    oldData = JSON.stringify({ title, data: { headers, rows } });

    const tableHeaders = headers.map(header => `<th>${header}</th>`).join('');
    const tableRows = Object.values(rows).map(row => `
      <tr>
        <td>${row.id}</td>
        <td>${row.fname}</td>
        <td>${row.lname}</td>
        <td>${row.email}</td>
        <td>${new Date(row.date * 1000).toLocaleDateString()}</td>
      </tr>
    `).join('');

    document.getElementById('mp-be-test-table').innerHTML = `
      <table>
        <tr>${tableHeaders}</tr>
        ${tableRows}
      </table>
    `;
  };

  // Refresh data when the button is clicked.
  const refreshData = async () => {
    const data = await fetchData();
    if (data) displayData(data);
  };

  refreshButton.addEventListener('click', refreshData);
  refreshData();
});
