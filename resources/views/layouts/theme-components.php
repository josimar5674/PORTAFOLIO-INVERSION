<style>

/* ===============================
   TARJETAS
================================ */

.card,
.card-seccion,
.summary-card,
.module-card,
.dashboard-card,
.form-card,
.inversion-card,
.cliente-card,
.info-section{

    background:var(--surface);

    color:var(--text);

    border:1px solid var(--border);

    box-shadow:var(--shadow);

}

/* ===============================
   TITULOS
================================ */

.card-title,
.form-title,
.section-title,
.investment-header h1,
.cliente-title,
.dashboard-title{

    color:var(--text);

}

/* ===============================
   TEXTOS
================================ */

.card-info,
.cliente-info,
.user-role,
.info-label,
.summary-card,
.investment-header small{

    color:var(--text-secondary);

}

/* ===============================
   FORMULARIOS
================================ */

input,
select,
textarea,
.form-control{

    background:var(--surface);

    color:var(--text);

    border:1px solid var(--border);

}

input::placeholder,
textarea::placeholder{

    color:var(--text-secondary);

}

input:focus,
select:focus,
textarea:focus,
.form-control:focus{

    border-color:var(--primary);

    outline:none;

    box-shadow:0 0 0 3px rgba(234,207,51,.15);

}

/* ===============================
   TABLAS
================================ */

table{

    background:var(--surface);

    color:var(--text);

}

th{

    background:var(--surface-2);

    color:var(--text);

    border-bottom:1px solid var(--border);

}

td{

    color:var(--text);

    border-bottom:1px solid var(--border);

}

/* ===============================
   MODALES
================================ */

.modal-box{

    background:var(--surface);

    color:var(--text);

}

/* ===============================
   BOTONES SECUNDARIOS
================================ */

.btn-secondary,
.profile-btn{

    background:var(--surface-3);

    color:var(--text);

    border:1px solid var(--border);

}

/* ===============================
   ENLACES DE ACCIONES
================================ */

.actions a,
.card-actions a{

    background:var(--surface-3);

    color:var(--text);

}

/* ===============================
   CONTENEDORES
================================ */

.investment-header,
.topbar{

    background:var(--surface);

    border-bottom:1px solid var(--border);

    box-shadow:var(--shadow);

}

.card-seccion {

    padding:15px;

    border-radius:10px;

    margin-bottom:15px;

}

.card-seccion h4 {

    margin-bottom:10px;

}

.grid-3 {

    display:grid;

    grid-template-columns:1fr 1fr 1fr;

    gap:10px;

}

.grid-2 {

    display:grid;
    

    grid-template-columns:1fr 1fr;

    gap:10px;

}

input,
select,
textarea{

    width:100%;
    box-sizing:border-box;

}

.total-box {

    font-size:18px;

    text-align:right;


}







</style>