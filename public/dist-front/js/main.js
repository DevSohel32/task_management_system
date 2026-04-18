let tasks = [
  { id:1, title:'Design system audit', desc:'Review and update component library', status:'Completed', priority:'High', assignee:'Alex R.', due:'2026-04-05', initials:'AR', color:'#2563EB' },
  { id:2, title:'API integration for payments', desc:'Connect Stripe gateway to checkout flow', status:'In Progress', priority:'High', assignee:'Sara K.', due:'2026-04-14', initials:'SK', color:'#7C3AED' },
  { id:3, title:'Write Q2 release notes', desc:'Document all features shipped this quarter', status:'Pending', priority:'Medium', assignee:'Jibon M.', due:'2026-04-18', initials:'JM', color:'#D97706' },
  { id:4, title:'Mobile responsive fixes', desc:'Address layout issues on small screens', status:'In Progress', priority:'Medium', assignee:'Alex R.', due:'2026-04-12', initials:'AR', color:'#2563EB' },
  { id:5, title:'Setup CI/CD pipeline', desc:'Configure GitHub Actions for auto deploy', status:'Pending', priority:'High', assignee:'Rafi H.', due:'2026-04-20', initials:'RH', color:'#059669' },
  { id:6, title:'User onboarding flow', desc:'Design step-by-step guide for new users', status:'Pending', priority:'Low', assignee:'Sara K.', due:'2026-04-25', initials:'SK', color:'#7C3AED' },
  { id:7, title:'Performance benchmarking', desc:'Run Lighthouse audits on all pages', status:'Completed', priority:'Low', assignee:'Jibon M.', due:'2026-04-03', initials:'JM', color:'#D97706' },
];

let editId = null;
let currentFilter = 'all';

function badgeHtml(status) {
  const map = { 'Pending': 'badge-pending', 'In Progress': 'badge-progress', 'Completed': 'badge-done' };
  return `<span class="badge ${map[status]||'badge-pending'}"><span class="badge-dot"></span>${status}</span>`;
}

function priorityHtml(p) {
  const cls = p==='High'?'p-high':p==='Medium'?'p-med':'p-low';
  const icon = p==='High'?'fa-angle-double-up':p==='Medium'?'fa-equals':'fa-angle-double-down';
  return `<span class="priority ${cls}"><i class="fa-solid ${icon}"></i> ${p}</span>`;
}

function renderTasks() {
  const search = document.getElementById('searchInput').value.toLowerCase();
  const body = document.getElementById('taskBody');
  const filtered = tasks.filter(t => {
    const matchFilter = currentFilter==='all' || t.status===currentFilter;
    const matchSearch = t.title.toLowerCase().includes(search) || t.desc.toLowerCase().includes(search);
    return matchFilter && matchSearch;
  });

  body.innerHTML = filtered.map(t => `
    <tr class="task-row" id="row-${t.id}">
      <td>
        <div class="task-title-text">${t.title}</div>
        <div class="task-desc">${t.desc}</div>
      </td>
      <td>${badgeHtml(t.status)}</td>
      <td>${priorityHtml(t.priority)}</td>
      <td>
        <div class="task-meta">
          <div class="assignee-dot" style="background:${t.color}">${t.initials}</div>
          <span style="font-size:12px;color:#374151;">${t.assignee}</span>
        </div>
      </td>
      <td style="font-size:12px;color:#64748B;">${formatDate(t.due)}</td>
      <td>
        <div class="action-icons">
          <div class="icon-btn edit" onclick="editTask(${t.id})" title="Edit"><i class="fa-solid fa-pencil"></i></div>
          <div class="icon-btn del" onclick="deleteTask(${t.id})" title="Delete"><i class="fa-solid fa-trash"></i></div>
        </div>
      </td>
    </tr>
    <tr class="spacer-row"><td colspan="6"></td></tr>
  `).join('');

  updateStats();
}

function formatDate(d) {
  if(!d) return '—';
  const dt = new Date(d+'T00:00:00');
  return dt.toLocaleDateString('en-GB', {day:'2-digit', month:'short'});
}

function updateStats() {
  document.getElementById('statTotal').textContent = tasks.length;
  document.getElementById('statPending').textContent = tasks.filter(t=>t.status==='Pending').length;
  document.getElementById('statProgress').textContent = tasks.filter(t=>t.status==='In Progress').length;
  document.getElementById('statDone').textContent = tasks.filter(t=>t.status==='Completed').length;
}

function filterTasks(status, el) {
  currentFilter = status;
  document.querySelectorAll('.tab').forEach(t=>t.classList.remove('active'));
  el.classList.add('active');
  renderTasks();
}

function openModal() {
  editId = null;
  document.getElementById('modalTitle').textContent = 'Add New Task';
  document.getElementById('taskTitleInput').value = '';
  document.getElementById('taskDescInput').value = '';
  document.getElementById('taskStatusInput').value = 'Pending';
  document.getElementById('taskPriorityInput').value = 'Medium';
  document.getElementById('taskAssigneeInput').value = '';
  document.getElementById('taskDueInput').value = '';
  document.getElementById('modalOverlay').style.display = 'flex';
}

function editTask(id) {
  const t = tasks.find(x=>x.id===id);
  if(!t) return;
  editId = id;
  document.getElementById('modalTitle').textContent = 'Edit Task';
  document.getElementById('taskTitleInput').value = t.title;
  document.getElementById('taskDescInput').value = t.desc;
  document.getElementById('taskStatusInput').value = t.status;
  document.getElementById('taskPriorityInput').value = t.priority;
  document.getElementById('taskAssigneeInput').value = t.assignee;
  document.getElementById('taskDueInput').value = t.due;
  document.getElementById('modalOverlay').style.display = 'flex';
}

function closeModal() {
  document.getElementById('modalOverlay').style.display = 'none';
}

function handleOverlayClick(e) {
  if(e.target === document.getElementById('modalOverlay')) closeModal();
}

function saveTask() {
  const title = document.getElementById('taskTitleInput').value.trim();
  if(!title) { document.getElementById('taskTitleInput').style.borderColor='#EF4444'; return; }
  document.getElementById('taskTitleInput').style.borderColor='';
  const colors = ['#2563EB','#7C3AED','#D97706','#059669','#DC2626','#0891B2'];
  if(editId) {
    const t = tasks.find(x=>x.id===editId);
    const name = document.getElementById('taskAssigneeInput').value.trim()||t.assignee;
    t.title = title;
    t.desc = document.getElementById('taskDescInput').value.trim();
    t.status = document.getElementById('taskStatusInput').value;
    t.priority = document.getElementById('taskPriorityInput').value;
    t.assignee = name;
    t.initials = name.split(' ').map(w=>w[0]).join('').toUpperCase().slice(0,2)||'?';
    t.due = document.getElementById('taskDueInput').value;
    showToast('Task updated successfully');
  } else {
    const name = document.getElementById('taskAssigneeInput').value.trim()||'Unassigned';
    tasks.push({
      id: Date.now(),
      title,
      desc: document.getElementById('taskDescInput').value.trim()||'No description',
      status: document.getElementById('taskStatusInput').value,
      priority: document.getElementById('taskPriorityInput').value,
      assignee: name,
      due: document.getElementById('taskDueInput').value,
      initials: name.split(' ').map(w=>w[0]).join('').toUpperCase().slice(0,2)||'?',
      color: colors[Math.floor(Math.random()*colors.length)]
    });
    showToast('Task created successfully');
  }
  closeModal();
  renderTasks();
}

function deleteTask(id) {
  tasks = tasks.filter(t=>t.id!==id);
  renderTasks();
  showToast('Task removed');
}

function showToast(msg) {
  const t = document.getElementById('toast');
  document.getElementById('toastMsg').textContent = msg;
  t.classList.add('show');
  setTimeout(()=>t.classList.remove('show'), 2800);
}

document.getElementById('searchInput').addEventListener('input', renderTasks);

renderTasks();
