<style>

:root{

    --bg:#f3f4f6;

    --surface:#ffffff;

    --surface-2:#f9fafb;

    --surface-3:#f3f4f6;

    --text:#111827;

    --text-secondary:#6b7280;

    --border:#e5e7eb;

    --primary:#2563eb;

    --danger:#dc2626;
--card-info:#f9fafb;

    --card-info-border:#e5e7eb;
    --shadow:0 4px 12px rgba(0,0,0,.05);

}

html[data-theme="dark"]{

    --bg:#0f172a;

    --surface:#1e293b;

    --surface-2:#334155;

    --surface-3:#475569;

    --text:#f8fafc;

    --text-secondary:#cbd5e1;

    --border:#475569;

    --primary:#2563eb;

    --danger:#ef4444;
     --card-info:#334155;

    --card-info-border:#475569;

    --shadow:0 8px 20px rgba(0,0,0,.45);

}

.form-control {

    width: 100%;

    padding: 12px;

    border: 1px solid var(--border);

    border-radius: 10px;

    font-size: 14px;

    background: var(--surface);

    color: var(--text);

    transition: .2s;

}

body{

    margin:0;

    padding:0;

    background:var(--bg);

    color:var(--text);

    transition:background .3s,color .3s;

}


.topbar {

    background: var(--surface);

    padding: 15px 25px;

    display: flex;

    justify-content: space-between;

    align-items: center;

    border-bottom: 1px solid var(--border);

    box-shadow: var(--shadow);

}
/* ===========================
   DASHBOARD
=========================== */

.investment-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:25px;

    padding:20px;

    background:var(--surface);

    border-radius:12px;

    box-shadow:var(--shadow);

}

.investment-header h1{

    margin:0;

    font-size:28px;

    color:var(--text);

}

.investment-header small{

    color:var(--text-secondary);

    font-size:14px;

}

.summary-grid{

    display:grid;

    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));

    gap:15px;

    margin-bottom:35px;

}

.summary-card{

    background:var(--surface);

    border-radius:12px;

    padding:20px;

    box-shadow:var(--shadow);

    display:flex;

    flex-direction:column;

    gap:8px;

    font-size:14px;

    color:var(--text-secondary);

}

.summary-card strong{

    font-size:22px;

    color:var(--text);

}

.module-grid{

    display:grid;

    grid-template-columns:repeat(auto-fill,minmax(220px,1fr));

    gap:20px;

}

.module-card{

    text-decoration:none;

    background:var(--surface);

    border-radius:14px;

    padding:25px;

    box-shadow:var(--shadow);

    transition:.25s;

    color:var(--text);

    display:flex;

    flex-direction:column;

    align-items:center;

    justify-content:center;

    gap:10px;

    min-height:140px;

}

.module-card:hover{

    transform:translateY(-4px);

    box-shadow:0 10px 25px rgba(0,0,0,.18);

}

.module-card .icon{

    font-size:40px;

}

.module-card .title{

    font-size:16px;

    font-weight:600;

}

.module-card .action{

    font-size:13px;

    color:#2563eb;

}

.info-section{

    margin-top:40px;

    background:var(--surface);

    border-radius:12px;

    padding:25px;

    box-shadow:var(--shadow);

}

.info-grid{

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:20px;

}

.info-item{

    padding:12px;

    border-bottom:1px solid var(--border);

}

.info-label{

    font-size:13px;

    color:var(--text-secondary);

    margin-bottom:5px;

}

.info-value{

    font-weight:600;

    color:var(--text);

}

.metric-good{

    color:#16a34a;

}

.metric-warning{

    color:#ca8a04;

}

.metric-danger{

    color:var(--danger);

}

/* ===========================
   TABLA
=========================== */

.table-dashboard{

    width:100%;

    border-collapse:collapse;

    background:var(--surface);

    margin:0 auto;

    text-align:center;

    color:var(--text);

}

.table-dashboard th{

    text-align:center;

    vertical-align:middle;

    background:var(--surface-2);

    color:var(--text);

    border-bottom:1px solid var(--border);

}

.table-dashboard td{

    text-align:center;

    vertical-align:middle;

    color:var(--text);

    border-bottom:1px solid var(--border);

}

.table-dashboard td:first-child,

.table-dashboard th:first-child{

    text-align:left;

}

.table-dashboard td:nth-child(2),

.table-dashboard td:nth-child(3),

.table-dashboard td:nth-child(4){

    text-align:center;

}

.table-dashboard tbody tr{

    transition:.2s;

}

.table-dashboard tbody tr:hover{

    background:var(--surface-2) !important;

    cursor:pointer;

}

.table-dashboard tbody tr:hover td:first-child{

    color:#2563eb;

    font-weight:700;

}

/* ===========================
   BOTÓN TEMA
=========================== */

.theme-btn{

    width:42px;

    height:42px;

    border:none;

    border-radius:50%;

    background:var(--surface);

    color:var(--text);

    cursor:pointer;

    font-size:20px;

    margin-right:15px;

    box-shadow:var(--shadow);

    transition:.25s;

}

.theme-btn:hover{

    transform:scale(1.08);

}

@media(max-width:768px){

    .investment-header{

        flex-direction:column;

        align-items:flex-start;

        gap:15px;

    }

    .info-grid{

        grid-template-columns:1fr;

    }

}


.btn-new {
    background: #497fcb;
    color: white;
    padding: 10px 18px;
    border-radius: 10px;
    font-weight: 600;
    display: inline-block;
    transition: .2s;
}

.btn-new:hover {
    background: #2d2c26;
}

.btn-secondary {
    background: #e5e7eb;
    color: #111827;
    padding: 10px 16px;
    border-radius: 10px;
    font-weight: 600;
    display: inline-block;
}

.btn-primary-custom {
    background: #2563eb;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 600;
    transition: .2s;
}

.btn-primary-custom:hover {
    background: #1d4ed8;
}

.btn-new{
    background:#2563eb;
}

.btn-new:hover{
    background:#1d4ed8;
}

.card-info{

    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:15px;
    padding:10px;
    margin-bottom:10px;

    background:var(--surface-2);
    border:1px solid var(--border);
    border-radius:8px;

}
</style>