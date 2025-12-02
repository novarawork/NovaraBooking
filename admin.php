<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Panel Admin · Turnos Fútbol 7</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    :root {
      --bg-main: #050712;
      --bg-card: #0b0d1a;
      --bg-card-alt: #101325;
      --accent: #4f8cff;
      --accent-soft: rgba(79, 140, 255, 0.15);
      --accent-strong: #ff6b81;
      --text-main: #e7e9f4;
      --text-muted: #9ea2b3;
      --border: rgba(255, 255, 255, 0.06);
      --danger: #ff4c6a;
      --success: #4caf50;
      --warning: #ffb300;
      --shadow-soft: 0 18px 45px rgba(0, 0, 0, 0.55);
      --radius-lg: 18px;
      --radius-md: 12px;
      --radius-pill: 999px;
    }

    * {
      box-sizing: border-box;
    }

    html,
    body {
      margin: 0;
      padding: 0;
      background: radial-gradient(circle at top, #101335, #050712 60%);
      color: var(--text-main);
      font-family: system-ui, -apple-system, BlinkMacSystemFont, "SF Pro Text", "Roboto", sans-serif;
      font-size: 14px;
    }

    body {
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding: 16px;
    }

    .admin-app {
      display: grid;
      grid-template-columns: 230px minmax(0, 1fr);
      gap: 16px;
      width: 100%;
      max-width: 1220px;
      min-height: 90vh;
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.02), rgba(255, 255, 255, 0.04));
      border-radius: 24px;
      border: 1px solid rgba(255, 255, 255, 0.08);
      box-shadow: var(--shadow-soft);
      overflow: hidden;
      position: relative;
    }

    @media (max-width: 900px) {
      .admin-app {
        grid-template-columns: 1fr;
        grid-template-rows: auto auto;
      }
    }

    .admin-app::before {
      content: "";
      position: absolute;
      inset: 0;
      background:
        radial-gradient(circle at 10% 0%, rgba(79, 140, 255, 0.18), transparent 55%),
        radial-gradient(circle at 80% 100%, rgba(255, 107, 129, 0.22), transparent 50%);
      opacity: 0.65;
      pointer-events: none;
      z-index: -1;
    }

    /* Sidebar */
    .sidebar {
      background: rgba(2, 3, 10, 0.96);
      border-right: 1px solid rgba(255, 255, 255, 0.08);
      padding: 14px 10px;
      display: flex;
      flex-direction: column;
      gap: 16px;
      position: relative;
      z-index: 1;
    }

    @media (max-width: 900px) {
      .sidebar {
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        padding: 10px 12px;
      }
    }

    .sidebar-logo {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 4px;
      font-weight: 600;
      letter-spacing: 0.03em;
      font-size: 13px;
      color: #f5f6ff;
    }

    .sidebar-logo::before {
      content: "C7";
      width: 32px;
      height: 32px;
      border-radius: 12px;
      background: conic-gradient(from 220deg, #4f8cff, #ff6b81, #f7b500, #4f8cff);
      display: flex;
      align-items: center;
      justify-content: center;
      color: #0b0d1a;
      font-weight: 700;
      font-size: 15px;
      box-shadow:
        0 0 0 1px rgba(5, 7, 18, 0.6),
        0 12px 25px rgba(0, 0, 0, 0.8);
    }

    .sidebar-nav {
      display: flex;
      flex-direction: column;
      gap: 6px;
      margin-top: 6px;
      flex: 1;
    }

    @media (max-width: 900px) {
      .sidebar-nav {
        flex-direction: row;
        flex-wrap: wrap;
        margin-top: 0;
      }
    }

    .nav-item {
      position: relative;
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 7px 8px;
      border-radius: 999px;
      background: transparent;
      color: var(--text-muted);
      font-size: 12px;
      cursor: pointer;
      transition: all 0.18s ease-out;
      border: 1px solid transparent;
    }

    .nav-item::before {
      content: attr(data-icon);
      font-size: 13px;
      display: inline-flex;
      width: 22px;
      height: 22px;
      border-radius: 999px;
      align-items: center;
      justify-content: center;
      background: rgba(255, 255, 255, 0.04);
    }

    .nav-item span {
      white-space: nowrap;
    }

    .nav-item.active {
      background:
        radial-gradient(circle at 0 0, rgba(79, 140, 255, 0.3), transparent 60%),
        linear-gradient(135deg, rgba(79, 140, 255, 0.16), rgba(255, 255, 255, 0.03));
      color: #ffffff;
      border-color: rgba(79, 140, 255, 0.7);
      box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.5);
    }

    .nav-item:hover:not(.active) {
      background: rgba(255, 255, 255, 0.03);
      border-color: rgba(255, 255, 255, 0.02);
    }

    .sidebar-footer {
      font-size: 11px;
      color: var(--text-muted);
      padding: 10px 6px 4px;
      border-top: 1px dashed rgba(255, 255, 255, 0.08);
      margin-top: 10px;
    }

    @media (max-width: 900px) {
      .sidebar-footer {
        display: none;
      }
    }

    /* Content */
    .content {
      padding: 14px 14px 16px;
      display: flex;
      flex-direction: column;
      gap: 12px;
      position: relative;
      z-index: 1;
    }

    .topbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 10px;
    }

    .topbar-left {
      display: flex;
      flex-direction: column;
      gap: 2px;
    }

    .topbar-title {
      font-size: 16px;
      font-weight: 600;
    }

    .topbar-subtitle {
      font-size: 12px;
      color: var(--text-muted);
    }

    .topbar-right {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .pill {
      padding: 4px 10px;
      border-radius: 999px;
      border: 1px solid rgba(79, 140, 255, 0.4);
      background: rgba(79, 140, 255, 0.15);
      font-size: 11px;
      color: #e8f0ff;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }

    .pill::before {
      content: "";
      width: 7px;
      height: 7px;
      border-radius: 999px;
      background: #4caf50;
      box-shadow: 0 0 10px rgba(76, 175, 80, 0.7);
    }

    .user-pill {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 4px 9px;
      border-radius: 999px;
      background: rgba(7, 10, 22, 0.95);
      border: 1px solid rgba(255, 255, 255, 0.08);
      font-size: 11px;
    }

    .user-avatar {
      width: 24px;
      height: 24px;
      border-radius: 999px;
      background: radial-gradient(circle at 30% 0, #ffe082, #f57f17);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 11px;
      font-weight: 600;
      color: #2c1200;
    }

    .user-info span {
      display: block;
      line-height: 1.1;
    }

    .user-role {
      color: var(--text-muted);
    }

    /* Sections */
    .section {
      display: none;
      flex-direction: column;
      gap: 10px;
    }

    .section.active {
      display: flex;
    }

    .card {
      background:
        radial-gradient(circle at 0 0, rgba(255, 255, 255, 0.04), transparent 65%),
        radial-gradient(circle at 100% 100%, rgba(255, 107, 129, 0.08), transparent 55%),
        rgba(5, 7, 18, 0.96);
      border-radius: var(--radius-lg);
      padding: 10px 10px 12px;
      border: 1px solid rgba(255, 255, 255, 0.08);
      box-shadow: 0 16px 32px rgba(0, 0, 0, 0.7);
      position: relative;
      overflow: hidden;
    }

    .card::before {
      content: "";
      position: absolute;
      inset: -1px;
      border-radius: inherit;
      border: 1px solid rgba(255, 255, 255, 0.03);
      pointer-events: none;
    }

    .card-header {
      display: flex;
      justify-content: space-between;
      align-items: baseline;
      margin-bottom: 6px;
      gap: 6px;
    }

    .card-header h2 {
      font-size: 14px;
      margin: 0;
    }

    .card-header span {
      font-size: 11px;
      color: var(--text-muted);
    }

    .kpis {
      display: grid;
      grid-template-columns: repeat(4, minmax(0, 1fr));
      gap: 8px;
      margin-bottom: 8px;
    }

    @media (max-width: 900px) {
      .kpis {
        grid-template-columns: repeat(2, minmax(0, 1fr));
      }
    }

    .kpi-card {
      background: linear-gradient(135deg, rgba(79, 140, 255, 0.13), rgba(18, 22, 45, 0.95));
      border-radius: var(--radius-md);
      padding: 8px;
      border: 1px solid rgba(255, 255, 255, 0.08);
      display: flex;
      flex-direction: column;
      gap: 4px;
      position: relative;
      overflow: hidden;
    }

    .kpi-card:nth-child(2) {
      background: linear-gradient(135deg, rgba(102, 187, 106, 0.18), rgba(18, 26, 23, 0.99));
    }

    .kpi-card:nth-child(3) {
      background: linear-gradient(135deg, rgba(255, 202, 40, 0.16), rgba(28, 24, 9, 0.98));
    }

    .kpi-card:nth-child(4) {
      background: linear-gradient(135deg, rgba(236, 64, 122, 0.18), rgba(31, 10, 19, 0.98));
    }

    .kpi-title {
      font-size: 11px;
      color: var(--text-muted);
    }

    .kpi-value {
      font-size: 18px;
      font-weight: 600;
    }

    .kpi-subtext {
      font-size: 10px;
      color: var(--text-muted);
    }

    .kpi-chip {
      font-size: 10px;
      padding: 2px 7px;
      border-radius: 999px;
      border: 1px solid rgba(255, 255, 255, 0.2);
      background: rgba(0, 0, 0, 0.35);
      align-self: flex-start;
      margin-top: 2px;
    }

    .kpi-card .sparkline {
      position: absolute;
      bottom: -14px;
      right: -6px;
      width: 60px;
      height: 34px;
      opacity: 0.7;
      pointer-events: none;
    }

    .kpi-card .sparkline span {
      position: absolute;
      bottom: 0;
      width: 5px;
      border-radius: 999px;
      background: rgba(255, 255, 255, 0.45);
    }

    .kpi-card .sparkline span:nth-child(1) { left: 4px;  height: 14px; }
    .kpi-card .sparkline span:nth-child(2) { left: 14px; height: 22px; }
    .kpi-card .sparkline span:nth-child(3) { left: 24px; height: 11px; }
    .kpi-card .sparkline span:nth-child(4) { left: 34px; height: 26px; }
    .kpi-card .sparkline span:nth-child(5) { left: 44px; height: 18px; }

    .layout-two {
      display: grid;
      grid-template-columns: minmax(0, 1.1fr) minmax(0, 1fr);
      gap: 10px;
    }

    @media (max-width: 950px) {
      .layout-two {
        grid-template-columns: minmax(0, 1fr);
      }
    }

    .dashboard-two {
      display: grid;
      grid-template-columns: minmax(0, 1.2fr) minmax(0, 1fr);
      gap: 10px;
    }

    @media (max-width: 900px) {
      .dashboard-two {
        grid-template-columns: minmax(0, 1fr);
      }
    }

    /* Table */
    .table-wrapper {
      max-height: 260px;
      overflow: auto;
      margin-top: 4px;
      border-radius: var(--radius-md);
      border: 1px solid rgba(255, 255, 255, 0.06);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 11px;
    }

    thead {
      background: rgba(255, 255, 255, 0.03);
      position: sticky;
      top: 0;
      z-index: 1;
    }

    th,
    td {
      padding: 6px 7px;
      text-align: left;
      border-bottom: 1px solid rgba(255, 255, 255, 0.04);
    }

    th {
      font-weight: 500;
      color: var(--text-muted);
    }

    tr:nth-child(even) td {
      background: rgba(255, 255, 255, 0.01);
    }

    .badge-green {
      background: rgba(76, 175, 80, 0.16);
      color: #a5d6a7;
      border-radius: 999px;
      padding: 2px 7px;
      font-size: 10px;
      border: 1px solid rgba(129, 199, 132, 0.6);
    }

    .badge-yellow {
      background: rgba(255, 202, 40, 0.22);
      color: #ffe082;
      border-radius: 999px;
      padding: 2px 7px;
      font-size: 10px;
      border: 1px solid rgba(255, 213, 79, 0.7);
    }

    .badge-red {
      background: rgba(244, 67, 54, 0.16);
      color: #ef9a9a;
      border-radius: 999px;
      padding: 2px 7px;
      font-size: 10px;
      border: 1px solid rgba(239, 83, 80, 0.7);
    }

    .badge-dot {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      font-size: 10px;
      color: var(--text-muted);
    }

    .badge-dot::before {
      content: "";
      width: 7px;
      height: 7px;
      border-radius: 999px;
      background: rgba(79, 140, 255, 0.8);
    }

    .filters-row {
      display: flex;
      flex-wrap: wrap;
      gap: 6px;
      margin-bottom: 4px;
    }

    .filter-input {
      background: rgba(7, 9, 20, 0.9);
      border-radius: var(--radius-pill);
      border: 1px solid rgba(255, 255, 255, 0.08);
      color: var(--text-main);
      font-size: 11px;
      padding: 5px 10px;
      outline: none;
    }

    .filter-input::placeholder {
      color: rgba(158, 162, 179, 0.8);
    }

    .filter-input:focus {
      border-color: rgba(79, 140, 255, 0.7);
      box-shadow: 0 0 0 1px rgba(79, 140, 255, 0.4);
    }

    /* Buttons */
    .btn {
      border: none;
      border-radius: var(--radius-pill);
      padding: 6px 12px;
      font-size: 11px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      cursor: pointer;
      transition: all 0.16s ease-out;
      white-space: nowrap;
    }

    .btn-primary {
      background: linear-gradient(135deg, #4f8cff, #3f51b5);
      color: white;
      box-shadow: 0 10px 25px rgba(79, 140, 255, 0.55);
      border: 1px solid rgba(135, 170, 255, 0.8);
    }

    .btn-primary:hover {
      transform: translateY(-1px);
      box-shadow: 0 14px 28px rgba(79, 140, 255, 0.7);
    }

    .btn-outlined {
      background: rgba(5, 7, 18, 0.94);
      color: var(--text-main);
      border: 1px solid rgba(255, 255, 255, 0.12);
    }

    .btn-outlined:hover {
      border-color: rgba(79, 140, 255, 0.7);
      background: radial-gradient(circle at 0 0, rgba(79, 140, 255, 0.18), transparent 60%);
    }

    .btn-danger {
      border-color: rgba(255, 82, 82, 0.6);
      color: #ffcdd2;
    }

    .btn-danger:hover {
      background: radial-gradient(circle at 0 0, rgba(244, 67, 54, 0.35), transparent 55%);
    }

    .btn-success {
      border-color: rgba(76, 175, 80, 0.7);
      color: #c8e6c9;
    }

    .btn-small {
      padding: 4px 10px;
      font-size: 10px;
    }

    /* Calendar */
    .calendar-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 6px;
      margin-bottom: 4px;
      flex-wrap: wrap;
    }

    .calendar-nav {
      display: inline-flex;
      align-items: center;
      gap: 4px;
    }

    .calendar-nav button {
      width: 22px;
      height: 22px;
      border-radius: 999px;
      border: 1px solid rgba(255, 255, 255, 0.16);
      background: rgba(7, 9, 20, 0.9);
      color: #e0e3ff;
      font-size: 11px;
      cursor: pointer;
    }

    .calendar-nav span {
      font-size: 12px;
      color: var(--text-main);
    }

    .calendar-grid {
      display: grid;
      grid-template-columns: repeat(7, minmax(0, 1fr));
      gap: 4px;
      font-size: 10px;
      margin-top: 4px;
    }

    .cal-day-header {
      text-align: center;
      color: var(--text-muted);
      margin-bottom: 2px;
    }

    .cal-cell {
      height: 38px;
      border-radius: 10px;
      border: 1px solid rgba(255, 255, 255, 0.04);
      background: rgba(7, 9, 20, 0.96);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 4px;
      cursor: pointer;
      position: relative;
      overflow: hidden;
    }

    .cal-cell.selected {
      border-color: rgba(79, 140, 255, 0.9);
      box-shadow: 0 0 0 1px rgba(79, 140, 255, 0.5);
      background: radial-gradient(circle at 0 0, rgba(79, 140, 255, 0.28), rgba(7, 9, 20, 0.98));
    }

    .cal-date {
      font-size: 11px;
      color: var(--text-main);
    }

    .cal-dot {
      width: 6px;
      height: 6px;
      border-radius: 999px;
      background: rgba(255, 255, 255, 0.12);
      position: absolute;
      bottom: 4px;
      left: 4px;
    }

    .cal-dot.has-bookings {
      background: #4f8cff;
      box-shadow: 0 0 10px rgba(79, 140, 255, 0.9);
    }

    /* Booking list & detail */
    .list {
      display: flex;
      flex-direction: column;
      gap: 6px;
      margin-top: 4px;
      max-height: 240px;
      overflow-y: auto;
      padding-right: 2px;
    }

    .booking-item {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 6px;
      padding: 6px 7px;
      border-radius: 12px;
      border: 1px solid rgba(255, 255, 255, 0.06);
      background: rgba(7, 9, 20, 0.96);
      cursor: pointer;
      transition: all 0.15s ease-out;
    }

    .booking-item:hover {
      border-color: rgba(79, 140, 255, 0.7);
      box-shadow:
        0 0 0 1px rgba(79, 140, 255, 0.35),
        0 10px 24px rgba(0, 0, 0, 0.7);
    }

    .booking-item.selected {
      border-color: rgba(79, 140, 255, 0.9);
      box-shadow:
        0 0 0 1px rgba(79, 140, 255, 0.35),
        0 10px 24px rgba(0, 0, 0, 0.7);
      background: radial-gradient(circle at 0 0, rgba(79, 140, 255, 0.16), rgba(7, 9, 20, 0.96));
    }

    .booking-main {
      display: flex;
      flex-direction: column;
      gap: 3px;
    }

    .booking-title {
      font-size: 12px;
      font-weight: 500;
    }

    .booking-meta {
      font-size: 11px;
      color: var(--text-muted);
    }

    .booking-tags {
      display: flex;
      flex-wrap: wrap;
      gap: 4px;
      margin-top: 2px;
    }

    .tag {
      padding: 2px 7px;
      border-radius: 999px;
      font-size: 10px;
      border: 1px solid rgba(255, 255, 255, 0.14);
      background: rgba(255, 255, 255, 0.02);
      color: var(--text-muted);
    }

    .tag-green {
      background: rgba(76, 175, 80, 0.16);
      color: #a5d6a7;
      border-color: rgba(129, 199, 132, 0.7);
    }

    .tag-red {
      background: rgba(244, 67, 54, 0.16);
      color: #ef9a9a;
      border-color: rgba(239, 83, 80, 0.7);
    }

    .tag-yellow {
      background: rgba(255, 202, 40, 0.22);
      color: #ffe082;
      border-color: rgba(255, 213, 79, 0.7);
    }

    .detail-block {
      padding: 6px 7px 8px;
      border-radius: var(--radius-md);
      background: rgba(7, 9, 20, 0.96);
      border: 1px solid rgba(255, 255, 255, 0.06);
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    .detail-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 8px;
      flex-wrap: wrap;
    }

    .detail-title {
      font-size: 13px;
      font-weight: 500;
    }

    .hint {
      font-size: 11px;
      color: var(--text-muted);
    }

    .detail-row {
      display: flex;
      justify-content: space-between;
      font-size: 11px;
    }

    .detail-label {
      color: var(--text-muted);
    }

    .detail-value {
      font-weight: 500;
    }

    .divider {
      border-bottom: 1px dashed var(--border);
      margin: 4px 0;
      opacity: 0.8;
    }

    /* Pagos por jugador */
    .players-grid {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 4px;
      margin-top: 4px;
      max-height: 170px;
      overflow-y: auto;
      padding-right: 2px;
    }

    @media (max-width: 600px) {
      .players-grid {
        grid-template-columns: minmax(0, 1fr);
      }
    }

    .player-row {
      border-radius: 10px;
      border: 1px solid var(--border);
      background: rgba(10, 11, 18, 0.96);
      padding: 5px 6px;
      display: flex;
      flex-direction: column;
      gap: 2px;
      font-size: 11px;
    }

    .player-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 4px;
    }

    .player-name {
      font-weight: 500;
    }

    .player-status {
      font-size: 10px;
      padding: 2px 6px;
      border-radius: 999px;
      border: 1px solid var(--border);
      color: var(--text-muted);
    }

    .player-status.pagado {
      border-color: rgba(76, 175, 80, 0.6);
      color: #a5d6a7;
      background: rgba(76, 175, 80, 0.15);
    }

    .player-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 4px;
      font-size: 10px;
      color: var(--text-muted);
    }

    .chip-toggle {
      padding: 2px 6px;
      border-radius: 999px;
      border: 1px dashed rgba(255, 255, 255, 0.18);
      cursor: pointer;
      font-size: 10px;
      background: rgba(7, 9, 20, 0.98);
    }

    .chip-toggle.active {
      border-style: solid;
      border-color: rgba(79, 140, 255, 0.8);
      background: rgba(79, 140, 255, 0.18);
      color: #e3f2fd;
    }

    /* Clients */
    .client-tag {
      font-size: 10px;
      padding: 2px 6px;
      border-radius: 999px;
      border: 1px solid rgba(255, 255, 255, 0.16);
      background: rgba(255, 255, 255, 0.02);
      color: var(--text-muted);
    }

    /* Toast */
    .toast {
      position: fixed;
      bottom: 16px;
      left: 50%;
      transform: translateX(-50%) translateY(60px);
      background: rgba(5, 7, 18, 0.98);
      padding: 7px 12px;
      border-radius: 999px;
      border: 1px solid rgba(255, 255, 255, 0.12);
      font-size: 11px;
      color: #f5f6ff;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.7);
      opacity: 0;
      pointer-events: none;
      transition: all 0.35s ease;
      z-index: 9999;
    }

    .toast.show {
      transform: translateX(-50%) translateY(0);
      opacity: 1;
    }
  </style>
</head>
<body>
<div class="admin-app">
  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="sidebar-logo">C7</div>
    <nav class="sidebar-nav">
      <div class="nav-item active" data-section="dashboard" data-icon="📊"><span>Dash</span></div>
      <div class="nav-item" data-section="calendar" data-icon="📅"><span>Cal</span></div>
      <div class="nav-item" data-section="bookings" data-icon="📋"><span>Turnos</span></div>
      <div class="nav-item" data-section="clients" data-icon="👥"><span>Clientes</span></div>
      <div class="nav-item" data-section="settings" data-icon="⚙️"><span>Config</span></div>
    </nav>
<div class="sidebar-footer">
  Admin<br/>
  <span style="color:#e57373;">Super</span> / Staff
  <br><br>
  <a href="../panel.php" style="color:#64b5f6; text-decoration:none; font-size:11px;">
    Cambiar módulo
  </a><br/>
  <a href="logout.php" style="color:#ef9a9a; text-decoration:none; font-size:11px;">
    Cerrar sesión
  </a>
</div>

  </aside>

  <!-- MAIN CONTENT -->
  <div class="content">
    <!-- TOPBAR -->
    <div class="topbar">
      <div class="topbar-left">
        <div class="topbar-title">Panel de administración</div>
        <div class="topbar-subtitle">Gestión de turnos, clientes, caja y horarios de funcionamiento</div>
      </div>
      <div class="topbar-right">
        <div class="pill">Conectado · Panel de turnos</div>
        <div class="user-pill">
          <div class="user-avatar">DS</div>
          <div class="user-info">
            <span>Diego</span>
            <span class="user-role">Rol: <strong>Admin superior</strong></span>
          </div>
        </div>
      </div>
    </div>

    <!-- SECTIONS WRAPPER -->
    <div class="content">
      <!-- DASHBOARD -->
      <section class="section active" id="section-dashboard">
        <div class="card">
          <div class="card-header">
            <h2>Resumen del día</h2>
            <span>Visión rápida del complejo</span>
          </div>
          <div class="kpis">
            <div class="kpi-card">
              <div class="kpi-title">Turnos de hoy</div>
              <div class="kpi-value">12</div>
              <div class="kpi-subtext">4 canchas · 3 horarios pico</div>
              <div class="kpi-chip">+3 vs. ayer</div>
              <div class="sparkline">
                <span></span><span></span><span></span><span></span><span></span>
              </div>
            </div>
            <div class="kpi-card">
              <div class="kpi-title">Facturación estimada</div>
              <div class="kpi-value">$672.000</div>
              <div class="kpi-subtext">Basado en 14 jugadores por turno</div>
              <div class="kpi-chip">AR$ 4.000 / jugador</div>
              <div class="sparkline">
                <span></span><span></span><span></span><span></span><span></span>
              </div>
            </div>
            <div class="kpi-card">
              <div class="kpi-title">Señas pendientes</div>
              <div class="kpi-value">3</div>
              <div class="kpi-subtext">Recordá confirmar antes de las 18:00</div>
              <div class="kpi-chip">2 de clientes frecuentes</div>
              <div class="sparkline">
                <span></span><span></span><span></span><span></span><span></span>
              </div>
            </div>
            <div class="kpi-card">
              <div class="kpi-title">Faltas del mes</div>
              <div class="kpi-value">5</div>
              <div class="kpi-subtext">3 con aviso · 2 sin aviso</div>
              <div class="kpi-chip">Ver reporte detallado</div>
              <div class="sparkline">
                <span></span><span></span><span></span><span></span><span></span>
              </div>
            </div>
          </div>

          <div class="dashboard-two">
            <!-- Hoy -->
            <div class="card" style="margin-bottom:0;">
              <div class="card-header" style="margin-bottom:4px;">
                <h2>Hoy en el complejo</h2>
                <span>Turno en curso · Próximos</span>
              </div>
              <div class="detail-block" style="padding:7px 8px;">
                <div class="detail-header">
                  <div>
                    <div class="detail-title">En curso: 20:00 · Cancha 1 Techada</div>
                    <div class="hint">Quedan 32 minutos · Próximo a las 21:00</div>
                  </div>
                  <div style="display:flex; gap:4px; flex-wrap:wrap;">
                    <button class="btn btn-outlined btn-small btn-success" type="button">Agregar turno rápido</button>
                    <button class="btn btn-outlined btn-small" type="button">Ver agenda completa</button>
                  </div>
                </div>
                <div class="divider"></div>
                <div class="detail-row">
                  <span class="detail-label">Turnos confirmados hoy</span>
                  <span class="detail-value">12</span>
                </div>
                <div class="detail-row">
                  <span class="detail-label">Turnos cancelados</span>
                  <span class="detail-value">2</span>
                </div>
                <div class="detail-row">
                  <span class="detail-label">Turnos fallados</span>
                  <span class="detail-value">1</span>
                </div>
              </div>
            </div>

            <!-- Gráfico métodos de pago -->
            <div class="card" style="margin-bottom:0;">
              <div class="card-header" style="margin-bottom:4px;">
                <h2>Distribución de métodos de pago</h2>
                <span>Visual rápido para caja</span>
              </div>
              <div style="display:flex; flex-direction:column; gap:8px; padding:4px 2px 0;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                  <span class="detail-label">Efectivo</span>
                  <span class="detail-value" id="stats-cash-amount">$0</span>
                </div>
                <div style="width:100%; height:7px; border-radius:999px; background:rgba(255,255,255,0.06); overflow:hidden;">
                  <div id="stats-cash-bar"
                       style="width:0%; height:100%; background:linear-gradient(90deg,#4caf50,#81c784);"></div>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center;">
                  <span class="detail-label">Mercado Pago</span>
                  <span class="detail-value" id="stats-mp-amount">$0</span>
                </div>
                <div style="width:100%; height:7px; border-radius:999px; background:rgba(255,255,255,0.06); overflow:hidden;">
                  <div id="stats-mp-bar"
                       style="width:0%; height:100%; background:linear-gradient(90deg,#4f8cff,#82b1ff);"></div>
                </div>
                <div class="divider"></div>
                <p style="font-size:11px; color:var(--text-muted); margin:0;">
                  A medida que marcás los pagos de los jugadores, estos montos se actualizan.
                  Más adelante se pueden conectar a la caja real por día, semana o mes.
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Centro de control / features -->
        <div class="card">
          <div class="card-header">
            <h2>Centro de control</h2>
            <span>Reportes, estadísticas y herramientas avanzadas</span>
          </div>
          <div style="display:grid; grid-template-columns: minmax(0,1.2fr) minmax(0,1fr); gap:10px;">
            <div>
              <ul style="font-size:11px; color:var(--text-muted); margin:0; padding-left:16px;">
                <li>✔ Ver estadísticas reales (día, semana, mes)</li>
                <li>✔ Reporte económico por día / semana / mes</li>
                <li>✔ Sistema de búsqueda avanzada en clientes</li>
                <li>✔ Notas internas por turno</li>
                <li>✔ Confirmaciones por WhatsApp</li>
                <li>✔ Exportar a Excel / PDF</li>
                <li>✔ Dashboard más visual (gráficos)</li>
              </ul>
            </div>
            <div style="display:flex; flex-direction:column; gap:6px; font-size:11px;">
              <button class="btn btn-primary btn-small" type="button" id="btn-open-report-day">
                Ver reporte económico de hoy
              </button>
              <button class="btn btn-outlined btn-small" type="button" id="btn-open-report-week">
                Ver estadísticas de la semana
              </button>
              <button class="btn btn-outlined btn-small" type="button" id="btn-open-report-month">
                Ver estadísticas del mes
              </button>
              <p style="margin:4px 0 0; color:var(--text-muted);">
                Estos botones se pueden conectar luego a un endpoint
                <code>/api/stats.php?range=day|week|month</code> para traer datos reales.
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- CALENDAR & DAILY BOOKINGS -->
      <section class="section" id="section-calendar">
        <div class="layout-two">
          <!-- COLUMNA IZQUIERDA -->
          <div>
            <div class="card">
              <div class="card-header">
                <h2>Calendario de turnos</h2>
                <span>Vista mensual</span>
              </div>

              <div class="calendar-header">
                <div class="calendar-nav">
                  <button type="button" id="btn-prev-month">&lt;</button>
                  <span id="calendar-month-label">Noviembre 2025</span>
                  <button type="button" id="btn-next-month">&gt;</button>
                </div>
                <div style="display:flex; gap:4px; flex-wrap:wrap; justify-content:flex-end;">
                  <button class="btn btn-outlined btn-small" type="button" id="btn-today">
                    Turnos de hoy
                  </button>
                  <select class="filter-input" style="min-width:130px;" id="calendar-filter-pitch">
                    <option value="all">Todas las canchas</option>
                    <option value="1">Cancha 1</option>
                    <option value="2">Cancha 2</option>
                    <option value="3">Cancha 3</option>
                  </select>
                  <button class="btn btn-outlined btn-small" type="button" id="btn-open-settings-from-calendar">Configurar horarios</button>
                </div>
              </div>

              <div class="calendar-grid" id="calendar-grid">
                <!-- encabezados -->
                <div class="cal-day-header">Lun</div>
                <div class="cal-day-header">Mar</div>
                <div class="cal-day-header">Mié</div>
                <div class="cal-day-header">Jue</div>
                <div class="cal-day-header">Vie</div>
                <div class="cal-day-header">Sáb</div>
                <div class="cal-day-header">Dom</div>
                <!-- celdas se generan por JS -->
              </div>

              <div class="divider" style="margin:8px 0;"></div>
              <div class="card-header" style="margin-bottom:4px;">
                <h2 id="day-bookings-title" style="font-size:13px;">Turnos del día</h2>
                <span style="font-size:10px;">Lista del día</span>
              </div>
              <div class="list" id="booking-list"></div>
            </div>

            <!-- NOTAS RÁPIDAS -->
            <div class="card" style="margin-top:8px; max-height:160px;">
              <div class="card-header">
                <h2>Notas rápidas</h2>
                <span>Recordatorios del día</span>
              </div>
              <p style="font-size:11px; color:var(--text-muted); margin-bottom:6px;">
                Podés anotar situaciones del día, equipos que piden turnos fijos o temas a revisar.
              </p>
              <ul style="font-size:11px; color:var(--text-muted); padding-left:18px; margin:0;">
                <li>Revisar luces de la cancha 2 antes del último turno.</li>
                <li>Confirmar seña de Los Pibes FC para el sábado.</li>
                <li>Chequear clima para el domingo y avisar a turnos al aire libre.</li>
              </ul>
            </div>
          </div>

          <!-- COLUMNA DERECHA -->
          <div>
            <!-- DETALLE TURNO -->
            <div class="card">
              <div class="card-header">
                <h2>Detalle del turno seleccionado</h2>
                <span>Pagos, acciones, estado</span>
              </div>
              <div class="detail-block">
                <div class="detail-header">
                  <div>
                    <div class="detail-title" id="detail-title">Seleccioná un turno</div>
                    <div class="hint" id="detail-hint">Acá vas a ver la información del turno.</div>
                  </div>
                  <div style="display:flex; gap:4px; flex-wrap:wrap; justify-content:flex-end;">
                    <button id="btn-whatsapp" class="btn btn-outlined btn-small" type="button">
                      Confirmar por WhatsApp
                    </button>
                    <button id="btn-nota-turno" class="btn btn-outlined btn-small" type="button">
                      Guardar nota
                    </button>
                    <button id="btn-cancelar" class="btn btn-outlined btn-small btn-danger" type="button">
                      Cancelar turno
                    </button>
                    <button id="btn-fallado" class="btn btn-outlined btn-small btn-danger" type="button">
                      Marcar como fallado
                    </button>
                  </div>
                </div>

                <div class="detail-row">
                  <span class="detail-label">Fecha</span>
                  <span class="detail-value" id="detail-date">—</span>
                </div>
                <div class="detail-row">
                  <span class="detail-label">Cliente</span>
                  <span class="detail-value" id="detail-client">—</span>
                </div>
                <div class="detail-row">
                  <span class="detail-label">Teléfono</span>
                  <span class="detail-value" id="detail-phone">—</span>
                </div>
                <div class="detail-row">
                  <span class="detail-label">Tipo de reserva</span>
                  <span class="detail-value" id="detail-reservation">—</span>
                </div>
                <div class="divider"></div>
                <div class="detail-row">
                  <span class="detail-label">Precio por persona</span>
                  <span class="detail-value" id="detail-price-per-person">—</span>
                </div>
                <div class="detail-row">
                  <span class="detail-label">Jugadores</span>
                  <span class="detail-value" id="detail-players">—</span>
                </div>
                <div class="detail-row">
                  <span class="detail-label">Total turno (estimado)</span>
                  <span class="detail-value" id="detail-total">—</span>
                </div>
                <div class="divider"></div>

                <label style="font-size:11px; color:var(--text-muted); display:block; margin-bottom:4px;">
                  Nota interna de este turno
                  <textarea id="detail-note" rows="2"
                            style="width:100%; margin-top:2px; resize:vertical; font-size:11px; background:rgba(7,9,20,0.9); border-radius:8px; border:1px solid rgba(255,255,255,0.08); color:var(--text-main); padding:4px 6px;"></textarea>
                </label>
              </div>
            </div>

            <!-- PRÓXIMOS TURNOS Y PAGOS POR JUGADOR -->
            <div class="card" style="margin-top:8px;">
              <div class="card-header">
                <h2>Próximos turnos del día</h2>
                <span>Ordenados por horario</span>
              </div>
              <div class="list" id="upcoming-list"></div>

              <div class="divider" style="margin:8px 0;"></div>
              <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:4px;">
                <span class="detail-label">Pagos por jugador</span>
                <div style="display:flex; gap:4px; flex-wrap:wrap;">
                  <button class="btn btn-outlined btn-small" type="button" id="btn-mark-all-cash">
                    Equipo: todo en efectivo
                  </button>
                  <button class="btn btn-outlined btn-small" type="button" id="btn-mark-all-mp">
                    Equipo: todo por MP
                  </button>
                  <button class="btn btn-outlined btn-small" type="button" id="btn-mark-all-paid">
                    Marcar todos pagados
                  </button>
                </div>
              </div>
              <div class="players-grid" id="players-grid">
                <!-- Se rellena dinámicamente -->
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- BOOKINGS TABLE -->
      <section class="section" id="section-bookings">
        <div class="card">
          <div class="card-header">
            <h2>Turnos</h2>
            <span>Lista, filtros, exportación</span>
          </div>
          <div class="filters-row">
            <input class="filter-input" id="bookings-filter-search" placeholder="Buscar por nombre / equipo / teléfono" />
            <select class="filter-input" id="bookings-filter-status">
              <option value="all">Estado: todos</option>
              <option value="confirmed">Confirmados</option>
              <option value="cancelled">Cancelados</option>
              <option value="pending">Seña pendiente</option>
              <option value="no_show">Fallados</option>
            </select>
            <select class="filter-input" id="bookings-filter-pitch">
              <option value="all">Cancha: todas</option>
              <option value="1">Cancha 1</option>
              <option value="2">Cancha 2</option>
              <option value="3">Cancha 3</option>
            </select>
            <input type="date" class="filter-input" id="bookings-filter-date-from" />
            <input type="date" class="filter-input" id="bookings-filter-date-to" />
            <button class="btn btn-outlined btn-small" type="button" id="btn-bookings-export-excel">Exportar Excel</button>
          </div>
          <div class="table-wrapper">
            <table>
              <thead>
              <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Cancha</th>
                <th>Cliente / equipo</th>
                <th>Teléfono</th>
                <th>Estado</th>
                <th>Pagos</th>
                <th>Total</th>
              </tr>
              </thead>
              <tbody id="bookings-table-body">
              <!-- filas dinámicas -->
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- CLIENTS -->
      <section class="section" id="section-clients">
        <div class="card">
          <div class="card-header">
            <h2>Clientes</h2>
            <span>Historial de turnos y fallas</span>
          </div>
          <div class="filters-row">
            <input class="filter-input" id="client-search-name" placeholder="Buscar cliente / equipo..." />
            <input class="filter-input" id="client-search-phone" placeholder="Teléfono..." />
            <input class="filter-input" id="client-search-tag" placeholder="Etiqueta / nota..." />
            <select class="filter-input" id="client-order">
              <option value="name">Ordenar por: nombre</option>
              <option value="most_bookings">Más turnos</option>
              <option value="last_booking">Último turno</option>
              <option value="most_no_shows">Más fallas</option>
            </select>
            <button class="btn btn-outlined btn-small" type="button" id="btn-advanced-search">
              Búsqueda avanzada
            </button>
            <button class="btn btn-outlined btn-small" type="button" id="btn-client-history">
              Ver historial de turnos por cliente
            </button>
            <button class="btn btn-outlined btn-small" type="button" id="btn-export-clients-excel">
              Exportar Excel
            </button>
            <button class="btn btn-outlined btn-small" type="button" id="btn-export-clients-pdf">
              Exportar PDF
            </button>
          </div>
          <div class="table-wrapper">
            <table>
              <thead>
              <tr>
                <th>Cliente</th>
                <th>Teléfono</th>
                <th>Total turnos</th>
                <th>Fallas</th>
                <th>Notas</th>
              </tr>
              </thead>
              <tbody>
              <tr>
                <td>Juan Pérez</td>
                <td>+54 9 351 123 4567</td>
                <td>18</td>
                <td>1</td>
                <td><span class="client-tag">Equipo: Los del Fondo</span></td>
              </tr>
              <tr>
                <td>Los Pibes FC</td>
                <td>+54 9 351 987 6543</td>
                <td>12</td>
                <td>0</td>
                <td><span class="client-tag">Turno fijo jueves 21:00</span></td>
              </tr>
              <tr>
                <td>Garra Blanca</td>
                <td>+54 9 351 222 3344</td>
                <td>9</td>
                <td>2</td>
                <td><span class="client-tag">Penalización por falla sin aviso</span></td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- SETTINGS -->
      <section class="section" id="section-settings">
        <div class="card">
          <div class="card-header">
            <h2>Configuración</h2>
            <span>Horarios, precios y parámetros del complejo</span>
          </div>
          <div class="layout-two">
            <!-- HORARIOS -->
            <div>
              <h3 style="font-size:12px; margin:0 0 6px;">Horarios habilitados</h3>
              <p style="font-size:11px; color:var(--text-muted); margin:0 0 8px;">
                Definí los días y horarios en los que se pueden reservar turnos.
              </p>
              <div class="table-wrapper" style="max-height:200px;">
                <table>
                  <thead>
                  <tr>
                    <th>Día</th>
                    <th>Habilitado</th>
                    <th>Desde</th>
                    <th>Hasta</th>
                  </tr>
                  </thead>
                  <tbody id="schedule-table-body">
                  <!-- Se llena desde la API -->
                  </tbody>
                </table>
              </div>
              <button id="btn-save-schedule" class="btn btn-primary btn-small" style="margin-top:6px;">
                Guardar cambios en horarios
              </button>
            </div>

            <!-- PRECIOS -->
            <div>
              <h3 style="font-size:12px; margin:0 0 6px;">Precios y parámetros</h3>
              <p style="font-size:11px; color:var(--text-muted); margin:0 0 8px;">
                Estos valores se usan para el cálculo del total estimado y los reportes.
              </p>
              <div style="display:flex; flex-direction:column; gap:6px;">
                <label style="font-size:11px; color:var(--text-muted);">
                  Precio por jugador (Fútbol 7)
                  <input id="input-price-per-player" type="number" min="0" step="100"
                         class="filter-input" style="width:100%; margin-top:2px;" value="4000" />
                </label>
                <label style="font-size:11px; color:var(--text-muted);">
                  Cantidad de jugadores por turno
                  <input id="input-players-per-booking" type="number" min="1" max="30"
                         class="filter-input" style="width:100%; margin-top:2px;" value="14" />
                </label>
                <label style="font-size:11px; color:var(--text-muted);">
                  Monto mínimo de seña
                  <input id="input-min-senia" type="number" min="0" step="100"
                         class="filter-input" style="width:100%; margin-top:2px;" value="8000" />
                </label>
              </div>
              <button id="btn-save-pricing" class="btn btn-primary btn-small" style="margin-top:8px;">
                Guardar configuración de precios
              </button>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>

<div id="toast" class="toast"></div>

<script>
  const apiBase = "/api";

  // Navegación entre secciones + recordar la última sección
  const navItems = document.querySelectorAll(".nav-item");
  const sections = document.querySelectorAll(".section");

  function showSection(name) {
    sections.forEach(sec => {
      sec.classList.toggle("active", sec.id === "section-" + name);
    });
    navItems.forEach(item => {
      item.classList.toggle("active", item.dataset.section === name);
    });
    try {
      localStorage.setItem("admin_active_section", name);
    } catch (e) {}
  }

  navItems.forEach(item => {
    item.addEventListener("click", () => {
      const sectionName = item.dataset.section;
      showSection(sectionName);
      if (sectionName === "bookings") {
        loadBookingsTable();
      }
    });
  });

  // Toast
  const toast = document.getElementById("toast");
  function showToast(msg) {
    if (!toast) return;
    toast.textContent = msg;
    toast.classList.add("show");
    setTimeout(() => toast.classList.remove("show"), 2500);
  }

  // ELEMENTOS PRINCIPALES
  const bookingListEl = document.getElementById("booking-list");
  const dayTitleEl = document.getElementById("day-bookings-title");
  const upcomingListEl = document.getElementById("upcoming-list");
  const playersGridEl = document.getElementById("players-grid");
  const detailTitleEl = document.getElementById("detail-title");
  const detailHintEl = document.getElementById("detail-hint");
  const detailDateEl = document.getElementById("detail-date");
  const detailClientEl = document.getElementById("detail-client");
  const detailPhoneEl = document.getElementById("detail-phone");
  const detailReservationEl = document.getElementById("detail-reservation");
  const detailPricePerPersonEl = document.getElementById("detail-price-per-person");
  const detailPlayersEl = document.getElementById("detail-players");
  const detailTotalEl = document.getElementById("detail-total");
  const detailNoteEl = document.getElementById("detail-note");

  const btnCancelar = document.getElementById("btn-cancelar");
  const btnFallado = document.getElementById("btn-fallado");
  const btnToday = document.getElementById("btn-today");
  const btnMarkAllPaid = document.getElementById("btn-mark-all-paid");
  const btnMarkAllCash = document.getElementById("btn-mark-all-cash");
  const btnMarkAllMp = document.getElementById("btn-mark-all-mp");
  const btnWhatsapp = document.getElementById("btn-whatsapp");
  const btnNotaTurno = document.getElementById("btn-nota-turno");
  const btnOpenSettingsFromCalendar = document.getElementById("btn-open-settings-from-calendar");

  // Stats métodos de pago
  const statsCashAmountEl = document.getElementById("stats-cash-amount");
  const statsMpAmountEl = document.getElementById("stats-mp-amount");
  const statsCashBarEl = document.getElementById("stats-cash-bar");
  const statsMpBarEl = document.getElementById("stats-mp-bar");

  let paymentStats = { cash: 0, mp: 0 };
  let paymentsByBooking = {};

  // Calendar elements
  const calendarGridEl = document.getElementById("calendar-grid");
  const calendarMonthLabel = document.getElementById("calendar-month-label");
  const btnPrevMonth = document.getElementById("btn-prev-month");
  const btnNextMonth = document.getElementById("btn-next-month");
  const calendarFilterPitch = document.getElementById("calendar-filter-pitch");

  // SETTINGS
  const scheduleTableBody = document.getElementById("schedule-table-body");
  const inputPricePerPlayer = document.getElementById("input-price-per-player");
  const inputPlayersPerBooking = document.getElementById("input-players-per-booking");
  const inputMinSenia = document.getElementById("input-min-senia");
  const btnSaveSchedule = document.getElementById("btn-save-schedule");
  const btnSavePricing = document.getElementById("btn-save-pricing");

  // CLIENTES
  const clientSearchName = document.getElementById("client-search-name");
  const clientSearchPhone = document.getElementById("client-search-phone");
  const clientSearchTag = document.getElementById("client-search-tag");
  const clientOrder = document.getElementById("client-order");
  const btnAdvancedSearch = document.getElementById("btn-advanced-search");
  const btnClientHistory = document.getElementById("btn-client-history");
  const btnExportClientsExcel = document.getElementById("btn-export-clients-excel");
  const btnExportClientsPdf = document.getElementById("btn-export-clients-pdf");

  const btnReportDay = document.getElementById("btn-open-report-day");
  const btnReportWeek = document.getElementById("btn-open-report-week");
  const btnReportMonth = document.getElementById("btn-open-report-month");

  // BOOKING LIST (sección calendario)
  let currentDate = new Date();
  let currentDateStr = currentDate.toISOString().slice(0, 10); // YYYY-MM-DD
  let bookings = [];           // bookings del día seleccionado
  let currentBooking = null;

  // Estado de jugadores por booking para pagos
  // paymentsByBooking[bookingId] = { pricePerPlayer: number, players: [ {name, paid, method} ] }

  // BOOKINGS TAB
  const bookingsTableBody = document.getElementById("bookings-table-body");
  const bookingsFilterSearch = document.getElementById("bookings-filter-search");
  const bookingsFilterStatus = document.getElementById("bookings-filter-status");
  const bookingsFilterPitch = document.getElementById("bookings-filter-pitch");
  const bookingsFilterDateFrom = document.getElementById("bookings-filter-date-from");
  const bookingsFilterDateTo = document.getElementById("bookings-filter-date-to");
  const btnBookingsExportExcel = document.getElementById("btn-bookings-export-excel");
  let bookingsTableData = [];  // todos los turnos cargados para la tabla

  function getTodayStr() {
    const d = new Date();
    return d.toISOString().slice(0, 10);
  }

  function formatDateDisplay(dateStr) {
    if (!dateStr) return "—";
    const [y, m, d] = dateStr.split("-");
    return `${d}/${m}/${y}`;
  }

  function formatTimeDisplay(timeStr) {
    if (!timeStr) return "";
    return timeStr.slice(0, 5);
  }

  function formatCurrency(amount) {
    if (amount == null || isNaN(amount)) return "$0";
    try {
      return "$" + Number(amount).toLocaleString("es-AR");
    } catch (e) {
      return "$" + amount;
    }
  }

  function diffMinutes(start, end) {
    if (!start || !end) return 60;
    const [sh, sm] = start.split(":").map(Number);
    const [eh, em] = end.split(":").map(Number);
    return (eh * 60 + em) - (sh * 60 + sm);
  }

  function statusInfo(status) {
    switch (status) {
      case "confirmed":
        return { label: "Confirmado", badgeClass: "badge-green" };
      case "cancelled":
        return { label: "Cancelado", badgeClass: "badge-red" };
      case "no_show":
        return { label: "Fallado", badgeClass: "badge-red" };
      case "pending":
        return { label: "Seña pendiente", badgeClass: "badge-yellow" };
      case "blocked":
        return { label: "Bloqueado", badgeClass: "badge-dot" };
      default:
        return { label: status || "Desconocido", badgeClass: "badge-yellow" };
    }
  }

  function reservationLabel(type) {
    if (type === "senia") return "Seña";
    if (type === "pago_local") return "Pagará localmente";
    return type || "Sin datos";
  }

  // -------- Stats métodos de pago (solo front-end por ahora) --------------

  function resetPaymentStats() {
    paymentStats.cash = 0;
    paymentStats.mp = 0;
    paymentsByBooking = {};
    updatePaymentStatsDisplay();
  }

  function updatePaymentStatsFromState() {
    let cash = 0;
    let mp = 0;

    Object.values(paymentsByBooking).forEach(bState => {
      const price = bState.pricePerPlayer || 0;
      (bState.players || []).forEach(p => {
        if (!p.paid || !p.method) return;
        if (p.method === "Efectivo") cash += price;
        if (p.method === "MP") mp += price;
      });
    });

    paymentStats.cash = cash;
    paymentStats.mp = mp;
    updatePaymentStatsDisplay();
  }

  function updatePaymentStatsDisplay() {
    const cash = paymentStats.cash || 0;
    const mp = paymentStats.mp || 0;
    const total = cash + mp;

    const cashPct = total ? (cash / total) * 100 : 0;
    const mpPct = total ? (mp / total) * 100 : 0;

    if (statsCashAmountEl) statsCashAmountEl.textContent = formatCurrency(Math.round(cash));
    if (statsMpAmountEl) statsMpAmountEl.textContent = formatCurrency(Math.round(mp));
    if (statsCashBarEl) statsCashBarEl.style.width = cashPct.toFixed(0) + "%";
    if (statsMpBarEl) statsMpBarEl.style.width = mpPct.toFixed(0) + "%";
  }

  // ------------------- CALENDARIO (vista mensual) -----------------------

  let calendarCurrentYear = currentDate.getFullYear();
  let calendarCurrentMonth = currentDate.getMonth(); // 0-11

  function getMonthNameEs(monthIndex) {
    const names = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
    return names[monthIndex] || "";
  }

  async function loadCalendarMonth(year, month) {
    if (!calendarGridEl) return;

    // encabezados (7)
    const headers = Array.from(calendarGridEl.querySelectorAll(".cal-day-header"));
    calendarGridEl.innerHTML = "";
    headers.forEach(h => calendarGridEl.appendChild(h));

    // info del mes
    const firstDay = new Date(year, month, 1);
    const firstWeekday = (firstDay.getDay() + 6) % 7; // 0 = lunes
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    // label
    if (calendarMonthLabel) {
      calendarMonthLabel.textContent = getMonthNameEs(month) + " " + year;
    }

    // celdas vacías antes del día 1
    for (let i = 0; i < firstWeekday; i++) {
      const empty = document.createElement("div");
      calendarGridEl.appendChild(empty);
    }

    // para marcar cuáles días tienen turnos
    let daysWithBookings = new Set();
    try {
      const monthStr = String(month + 1).padStart(2, "0");
      const from = `${year}-${monthStr}-01`;
      const to = `${year}-${monthStr}-${String(daysInMonth).padStart(2,"0")}`;

      const params = new URLSearchParams();
      params.set("action","calendar_month");
      params.set("from", from);
      params.set("to", to);
      const pitchFilterVal = calendarFilterPitch ? calendarFilterPitch.value : "all";
      if (pitchFilterVal && pitchFilterVal !== "all") {
        params.set("pitch_id", pitchFilterVal);
      }

      const res = await fetch(`${apiBase}/calendar.php?`+params.toString());
      const data = await res.json();
      if (data.success && Array.isArray(data.days)) {
        daysWithBookings = new Set(data.days.map(d => Number(d.day)));
      }
    } catch (err) {
      console.error("Error cargando info de calendario", err);
    }

    const todayStr = getTodayStr();
    for (let day = 1; day <= daysInMonth; day++) {
      const cell = document.createElement("div");
      cell.className = "cal-cell";
      cell.dataset.day = String(day);

      const dateStr = `${year}-${String(month+1).padStart(2,"0")}-${String(day).padStart(2,"0")}`;
      if (dateStr === todayStr) {
        cell.classList.add("selected");
        currentDateStr = dateStr;
      }

      cell.innerHTML = `<span class="cal-date">${day}</span>`;
      if (daysWithBookings.has(day)) {
        const dot = document.createElement("div");
        dot.className = "cal-dot has-bookings";
        cell.appendChild(dot);
      }

      cell.addEventListener("click", () => {
        calendarGridEl.querySelectorAll(".cal-cell").forEach(c => c.classList.remove("selected"));
        cell.classList.add("selected");
        currentDateStr = dateStr;
        loadBookings(currentDateStr);
      });

      calendarGridEl.appendChild(cell);
    }
  }

  // ------------------- BOOKINGS (vista día, columna izq/dcha) -----------------------

  async function loadBookings(dateStr) {
    if (!bookingListEl) return;
    try {
      bookingListEl.innerHTML =
        '<div style="font-size:11px; color:#9ea2b3; padding:4px 0;">Cargando turnos...</div>';

      resetPaymentStats();
      const res = await fetch(`${apiBase}/bookings.php?date=${encodeURIComponent(dateStr)}`);
      const data = await res.json();

      if (!data.success) {
        bookingListEl.innerHTML =
          `<div style="font-size:11px; color:#ef9a9a; padding:4px 0;">${data.error || "No se pudieron cargar los turnos."}</div>`;
        return;
      }

      bookings = Array.isArray(data.data) ? data.data : [];
      currentBooking = null;

      if (dayTitleEl) {
        dayTitleEl.textContent = "Turnos del " + formatDateDisplay(data.date || dateStr);
      }

      renderBookingList();
      renderBookingDetail(null);
      renderUpcomingBookings();
      renderPlayersForBooking(null);
    } catch (err) {
      console.error("Error loadBookings", err);
      bookingListEl.innerHTML =
        '<div style="font-size:11px; color:#ef9a9a; padding:4px 0;">Error de conexión al cargar turnos.</div>';
    }
  }

  function bookingStatusTagClass(status) {
    if (status === "cancelled") return "tag-red";
    if (status === "no_show") return "tag-yellow";
    if (status === "confirmed") return "tag-green";
    return "";
  }

  function renderBookingList() {
    if (!bookingListEl) return;
    if (!bookings.length) {
      bookingListEl.innerHTML =
        '<div style="font-size:11px; color:#9ea2b3; padding:4px 0;">No hay turnos para este día.</div>';
      return;
    }

    bookingListEl.innerHTML = "";

    bookings.forEach(b => {
      const info = statusInfo(b.status);
      const resLabel = reservationLabel(b.reservation_type);
      const paidInfo = `${b.paid_players || 0}/${b.total_players || 0} pagados`;
      const timeLabel = `${formatTimeDisplay(b.time_start)} · ${b.pitch_name || ("Cancha " + (b.pitch_id || ""))}`;

      const item = document.createElement("div");
      item.className = "booking-item";
      item.dataset.bookingId = b.id;

      const statusClass = bookingStatusTagClass(b.status);

      item.innerHTML = `
        <div class="booking-main">
          <div class="booking-title">${timeLabel}</div>
          <div class="booking-meta">
            Reserva: ${b.client_name || "Sin nombre"} · Tel: ${b.client_phone || "—"}
          </div>
          <div class="booking-tags">
            <span class="tag ${statusClass}">${info.label}</span>
            <span class="tag">${resLabel}</span>
            <span class="tag">${paidInfo}</span>
          </div>
        </div>
        <div style="display:flex; flex-direction:column; gap:4px;">
          <button class="btn btn-outlined btn-small btn-view" type="button">Ver</button>
          <button class="btn btn-outlined btn-small btn-duplicate" type="button">Duplicar turno</button>
        </div>
      `;

      item.addEventListener("click", (e) => {
        if (e.target && e.target.classList.contains("btn-duplicate")) {
          e.stopPropagation();
          showToast("Duplicar turno: conectar con backend.");
          return;
        }
        selectBooking(b.id);
      });

      const viewBtn = item.querySelector(".btn-view");
      if (viewBtn) {
        viewBtn.addEventListener("click", (e) => {
          e.stopPropagation();
          selectBooking(b.id);
        });
      }

      bookingListEl.appendChild(item);
    });
  }

  function renderUpcomingBookings() {
    if (!upcomingListEl) return;

    if (!bookings.length) {
      upcomingListEl.innerHTML =
        '<div style="font-size:11px; color:#9ea2b3; padding:4px 0;">No hay turnos para este día.</div>';
      return;
    }

    const sorted = bookings.slice().sort((a, b) => {
      return (a.time_start || "").localeCompare(b.time_start || "");
    });

    upcomingListEl.innerHTML = "";
    const now = new Date();
    const currentMinutes = now.getHours() * 60 + now.getMinutes();

    sorted.forEach(b => {
      const labelTime = formatTimeDisplay(b.time_start);
      const info = statusInfo(b.status);
      const minutesStart = b.time_start
        ? (parseInt(b.time_start.split(":")[0], 10) * 60 +
           parseInt(b.time_start.split(":")[1], 10))
        : 0;
      const isFuture = minutesStart >= currentMinutes;

      const item = document.createElement("div");
      item.className = "booking-item";
      if (!isFuture) {
        item.style.opacity = "0.6";
      }

      const statusClass = bookingStatusTagClass(b.status);

      item.innerHTML = `
        <div class="booking-main">
          <div class="booking-title">${labelTime} · ${b.pitch_name || ("Cancha " + (b.pitch_id || ""))}</div>
          <div class="booking-meta">${b.client_name || "Sin nombre"} · ${b.client_phone || "—"}</div>
          <div class="booking-tags">
            <span class="tag ${statusClass}">${info.label}</span>
          </div>
        </div>
      `;

      item.addEventListener("click", () => {
        selectBooking(b.id);
      });

      upcomingListEl.appendChild(item);
    });
  }

  function selectBooking(id) {
    const found = bookings.find(b => Number(b.id) === Number(id));
    if (!found) {
      showToast("No se encontró el turno.");
      return;
    }
    currentBooking = found;

    if (bookingListEl) {
      bookingListEl.querySelectorAll(".booking-item").forEach(el => {
        el.classList.toggle("selected", Number(el.dataset.bookingId) === Number(id));
      });
    }

    renderBookingDetail(found);
    renderPlayersForBooking(found);
  }

  function renderBookingDetail(b) {
    if (!detailTitleEl || !detailHintEl) return;

    if (!b) {
      detailTitleEl.textContent = "Seleccioná un turno";
      detailHintEl.textContent = "Elegí un turno de la lista para ver sus detalles.";
      if (detailDateEl) detailDateEl.textContent = "—";
      if (detailClientEl) detailClientEl.textContent = "—";
      if (detailPhoneEl) detailPhoneEl.textContent = "—";
      if (detailReservationEl) detailReservationEl.textContent = "—";
      if (detailPricePerPersonEl) detailPricePerPersonEl.textContent = "—";
      if (detailPlayersEl) detailPlayersEl.textContent = "—";
      if (detailTotalEl) detailTotalEl.textContent = "—";
      if (detailNoteEl) detailNoteEl.value = "";
      return;
    }

    const info = statusInfo(b.status);
    const resLabel = reservationLabel(b.reservation_type);
    const timeLabel = `${formatTimeDisplay(b.time_start)} · ${b.pitch_name || ("Cancha " + (b.pitch_id || ""))}`;
    const minutes = diffMinutes(b.time_start, b.time_end);
    const durationLabel = `Turno de ${minutes} min · Fútbol 7`;
    const players = b.total_players || 14;
    const pricePerPerson = players > 0 && b.total_price ? (Number(b.total_price) / players) : null;

    detailTitleEl.textContent = timeLabel;
    detailHintEl.textContent = `${durationLabel} · ${info.label}`;

    if (detailDateEl) detailDateEl.textContent = formatDateDisplay(b.date);
    if (detailClientEl) detailClientEl.textContent = b.client_name || "—";
    if (detailPhoneEl) detailPhoneEl.textContent = b.client_phone || "—";
    if (detailReservationEl) detailReservationEl.textContent = resLabel;
    if (detailPricePerPersonEl) {
      detailPricePerPersonEl.textContent = pricePerPerson != null ? formatCurrency(pricePerPerson) : "—";
    }
    if (detailPlayersEl) detailPlayersEl.textContent = players;
    if (detailTotalEl) detailTotalEl.textContent = formatCurrency(b.total_price);
    if (detailNoteEl) detailNoteEl.value = b.notes || "";
  }

  async function updateBookingStatus(actionType, label) {
    if (!currentBooking || !currentBooking.id) {
      showToast("Seleccioná un turno primero.");
      return;
    }
    const ok = window.confirm(`¿Seguro que querés ${label} este turno?`);
    if (!ok) return;

    try {
      const res = await fetch(`${apiBase}/bookings.php`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ action: actionType, booking_id: currentBooking.id })
      });
      const data = await res.json();
      if (!data.success) {
        showToast(data.error || "No se pudo actualizar el estado.");
        return;
      }
      showToast("Estado actualizado correctamente.");
      await loadBookings(currentDateStr);
      loadBookingsTable(); // refrescar tabla de turnos también
    } catch (err) {
      console.error("Error updateBookingStatus", err);
      showToast("Error de conexión con el servidor.");
    }
  }

  function buildBookingStateFor(b) {
    if (!b) return null;
    let existing = paymentsByBooking[b.id];
    if (existing) return existing;

    const totalPlayers = b.total_players
      || (inputPlayersPerBooking ? Number(inputPlayersPerBooking.value || 14) : 14)
      || 14;

    const pricePerPlayer = (b.total_price && totalPlayers)
      ? Number(b.total_price) / totalPlayers
      : (inputPricePerPlayer ? Number(inputPricePerPlayer.value || 0) : 0);

    const players = Array.from({ length: totalPlayers }, (_, i) => ({
      name: "Jugador " + (i + 1),
      paid: false,
      method: null
    }));

    existing = { bookingId: b.id, pricePerPlayer, players };
    paymentsByBooking[b.id] = existing;
    return existing;
  }

  function renderPlayersForBooking(b) {
    if (!playersGridEl) return;

    playersGridEl.innerHTML = "";

    if (!b) {
      playersGridEl.innerHTML =
        '<div style="font-size:11px; color:#9ea2b3;">Seleccioná un turno para ver los pagos por jugador.</div>';
      return;
    }

    const state = buildBookingStateFor(b);
    const players = state.players || [];

    players.forEach((p, idx) => {
      const row = document.createElement("div");
      row.className = "player-row";
      row.dataset.index = String(idx);
      row.dataset.bookingId = String(b.id);

      const statusText = p.paid ? "Pagó" : "No pagó";
      const statusExtraClass = p.paid ? " pagado" : "";
      const methodLabel = p.method ? p.method : "—";

      row.innerHTML = `
        <div class="player-header">
          <span class="player-name">${p.name || ("Jugador " + (idx + 1))}</span>
          <span class="player-status${statusExtraClass}">${statusText}</span>
        </div>
        <div class="player-footer">
          <div class="player-method">Método: ${methodLabel}</div>
          <div style="display:flex; gap:3px;">
            <span class="chip-toggle ${p.paid && p.method === "Efectivo" ? "active" : ""}" data-method="Efectivo">Efectivo</span>
            <span class="chip-toggle ${p.paid && p.method === "MP" ? "active" : ""}" data-method="MP">MP</span>
          </div>
        </div>
      `;

      playersGridEl.appendChild(row);
    });

    initPlayerPaymentDemoFunctional();
  }

  function initPlayerPaymentDemoFunctional() {
    document.querySelectorAll("#players-grid .player-row").forEach(row => {
      const status = row.querySelector(".player-status");
      const methodLabel = row.querySelector(".player-method");
      const chips = row.querySelectorAll(".chip-toggle");

      const bookingId = row.dataset.bookingId;
      const idx = Number(row.dataset.index || 0);
      const bookingState = paymentsByBooking[bookingId];

      chips.forEach(chip => {
        chip.addEventListener("click", function () {
          if (!bookingState || !bookingState.players[idx]) return;

          const method = chip.dataset.method || "MP";
          const player = bookingState.players[idx];

          // Toggle: si ya estaba activo, lo desmarco
          if (chip.classList.contains("active") && player.paid && player.method === method) {
            chip.classList.remove("active");
            if (status) {
              status.classList.remove("pagado");
              status.textContent = "No pagó";
            }
            if (methodLabel) {
              methodLabel.textContent = "Método: —";
            }
            player.paid = false;
            player.method = null;

            chips.forEach(c => c.classList.remove("active"));
          } else {
            // Activar este método
            chips.forEach(c => c.classList.remove("active"));
            chip.classList.add("active");
            if (status) {
              status.classList.add("pagado");
              status.textContent = "Pagó";
            }
            if (methodLabel) {
              methodLabel.textContent = "Método: " + method;
            }
            player.paid = true;
            player.method = method;
          }

          updatePaymentStatsFromState();
        });
      });
    });
  }

  function markAllPlayersInCurrentBooking(methodOrNull) {
    if (!currentBooking || !currentBooking.id) {
      showToast("Seleccioná un turno primero.");
      return;
    }
    const state = buildBookingStateFor(currentBooking);
    if (!state) return;

    state.players.forEach(p => {
      p.paid = true;
      if (methodOrNull) {
        p.method = methodOrNull;
      } else if (!p.method) {
        // si no se especifica método, dejamos pagado sin método
        p.method = null;
      }
    });

    renderPlayersForBooking(currentBooking);
    updatePaymentStatsFromState();
  }

  // ------------------- CONFIGURACIÓN (horarios / precios) -----------------------

  const WEEKDAY_NAMES = {
    1: "Lunes",
    2: "Martes",
    3: "Miércoles",
    4: "Jueves",
    5: "Viernes",
    6: "Sábado",
    7: "Domingo"
  };

  async function loadConfig() {
    try {
      const res = await fetch(`${apiBase}/settings.php?action=load`);
      const data = await res.json();
      if (!data.success) {
        showToast(data.error || "No se pudo cargar la configuración.");
        return;
      }

      if (scheduleTableBody && Array.isArray(data.schedule)) {
        renderScheduleTable(data.schedule);
      }

      if (data.pricing) {
        if (inputPricePerPlayer && typeof data.pricing.price_per_person !== "undefined") {
          inputPricePerPlayer.value = data.pricing.price_per_person;
        }
        if (inputPlayersPerBooking && typeof data.pricing.players_per_booking !== "undefined") {
          inputPlayersPerBooking.value = data.pricing.players_per_booking;
        }
        if (inputMinSenia && typeof data.pricing.min_senia_amount !== "undefined") {
          inputMinSenia.value = data.pricing.min_senia_amount;
        }
      }
    } catch (err) {
      console.error("Error loadConfig", err);
      showToast("Error de conexión al cargar configuración.");
    }
  }

  function renderScheduleTable(scheduleArr) {
    if (!scheduleTableBody) return;
    const byDay = {};
    scheduleArr.forEach(r => {
      byDay[r.weekday] = r;
    });

    scheduleTableBody.innerHTML = "";
    for (let w = 1; w <= 7; w++) {
      const row = byDay[w] || {
        weekday: w,
        enabled: 1,
        time_from: (w >= 1 && w <= 5) ? "14:00" : "15:00",
        time_to: (w === 7) ? "20:00" : "23:00"
      };
      const tr = document.createElement("tr");
      tr.dataset.weekday = String(w);
      tr.innerHTML = `
        <td>${WEEKDAY_NAMES[w]}</td>
        <td><input type="checkbox" ${row.enabled ? "checked" : ""} /></td>
        <td><input type="time" value="${row.time_from}" /></td>
        <td><input type="time" value="${row.time_to}" /></td>
      `;
      scheduleTableBody.appendChild(tr);
    }
  }

  function collectScheduleFromDOM() {
    if (!scheduleTableBody) return [];
    const result = [];
    scheduleTableBody.querySelectorAll("tr").forEach(tr => {
      const weekday = Number(tr.dataset.weekday || 0);
      if (!weekday) return;
      const inputs = tr.querySelectorAll("input");
      if (inputs.length < 3) return;
      const enabled = inputs[0].checked ? 1 : 0;
      const timeFrom = inputs[1].value || "00:00";
      const timeTo = inputs[2].value || "23:59";
      result.push({
        weekday,
        enabled,
        time_from: timeFrom,
        time_to: timeTo
      });
    });
    return result;
  }

  async function saveSchedule() {
    const schedule = collectScheduleFromDOM();
    if (!schedule.length) {
      showToast("No hay filas de horarios para guardar.");
      return;
    }
    try {
      const res = await fetch(`${apiBase}/settings.php`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          action: "save_schedule",
          schedule: schedule
        })
      });
      const data = await res.json();
      if (!data.success) {
        showToast(data.error || "No se pudieron guardar los horarios.");
        return;
      }
      showToast("Horarios guardados correctamente.");
    } catch (err) {
      console.error("Error saveSchedule", err);
      showToast("Error de conexión al guardar horarios.");
    }
  }

  async function savePricing() {
    if (!inputPricePerPlayer || !inputPlayersPerBooking || !inputMinSenia) {
      showToast("Faltan campos de configuración.");
      return;
    }
    const price = Number(inputPricePerPlayer.value || 0);
    const players = Number(inputPlayersPerBooking.value || 0);
    const minSenia = Number(inputMinSenia.value || 0);
    try {
      const res = await fetch(`${apiBase}/settings.php`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          action: "save_pricing",
          price_per_person: price,
          players_per_booking: players,
          min_senia_amount: minSenia
        })
      });
      const data = await res.json();
      if (!data.success) {
        showToast(data.error || "No se pudo guardar la configuración de precios.");
        return;
      }
      showToast("Precios guardados correctamente.");
      loadBookingsTable(); // refrescar tabla de turnos con nuevos montos
    } catch (err) {
      console.error("Error savePricing", err);
      showToast("Error de conexión al guardar precios.");
    }
  }

  // ------------------- TAB "TURNOS" (tabla grande) -----------------------

  function setDefaultBookingsDateFilters() {
    if (!bookingsFilterDateFrom || !bookingsFilterDateTo) return;
    const today = new Date();
    const to = today.toISOString().slice(0,10);
    const fromDate = new Date();
    fromDate.setDate(today.getDate() - 7);
    const from = fromDate.toISOString().slice(0,10);
    bookingsFilterDateFrom.value = from;
    bookingsFilterDateTo.value = to;
  }

  async function loadBookingsTable() {
    if (!bookingsTableBody) return;

    const params = new URLSearchParams();
    params.set("action","list");

    if (bookingsFilterDateFrom && bookingsFilterDateFrom.value) {
      params.set("from", bookingsFilterDateFrom.value);
    }
    if (bookingsFilterDateTo && bookingsFilterDateTo.value) {
      params.set("to", bookingsFilterDateTo.value);
    }
    if (bookingsFilterStatus && bookingsFilterStatus.value && bookingsFilterStatus.value !== "all") {
      params.set("status", bookingsFilterStatus.value);
    }
    if (bookingsFilterPitch && bookingsFilterPitch.value && bookingsFilterPitch.value !== "all") {
      params.set("pitch_id", bookingsFilterPitch.value);
    }

    try {
      bookingsTableBody.innerHTML = `
        <tr><td colspan="8" style="font-size:11px; color:#9ea2b3; padding:6px 8px;">
          Cargando turnos...
        </td></tr>`;

      const res = await fetch(`${apiBase}/bookings.php?` + params.toString());
      const data = await res.json();
      if (!data.success) {
        bookingsTableBody.innerHTML = `
          <tr><td colspan="8" style="font-size:11px; color:#ef9a9a; padding:6px 8px;">
            ${data.error || "No se pudieron cargar los turnos."}
          </td></tr>`;
        return;
      }

      bookingsTableData = Array.isArray(data.data) ? data.data : [];
      renderBookingsTable();
    } catch (err) {
      console.error("Error loadBookingsTable", err);
      bookingsTableBody.innerHTML = `
        <tr><td colspan="8" style="font-size:11px; color:#ef9a9a; padding:6px 8px;">
          Error de conexión al cargar turnos.
        </td></tr>`;
    }
  }

  function renderBookingsTable() {
    if (!bookingsTableBody) return;

    if (!bookingsTableData.length) {
      bookingsTableBody.innerHTML = `
        <tr><td colspan="8" style="font-size:11px; color:#9ea2b3; padding:6px 8px;">
          No hay turnos en el rango seleccionado.
        </td></tr>`;
      return;
    }

    const searchText = (bookingsFilterSearch?.value || "").toLowerCase().trim();

    const filtered = bookingsTableData.filter(b => {
      let ok = true;
      if (searchText) {
        const haystack = [
          b.client_name || "",
          b.client_phone || "",
          b.team_name || "",
          b.notes || ""
        ].join(" ").toLowerCase();
        ok = haystack.includes(searchText);
      }
      return ok;
    });

    if (!filtered.length) {
      bookingsTableBody.innerHTML = `
        <tr><td colspan="8" style="font-size:11px; color:#9ea2b3; padding:6px 8px;">
          No se encontraron turnos con esos filtros.
        </td></tr>`;
      return;
    }

    bookingsTableBody.innerHTML = "";
    filtered.forEach(b => {
      const info = statusInfo(b.status);
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${formatDateDisplay(b.date)}</td>
        <td>${formatTimeDisplay(b.time_start)}</td>
        <td>${b.pitch_name || ("Cancha " + (b.pitch_id || ""))}</td>
        <td>${b.client_name || "—"}</td>
        <td>${b.client_phone || "—"}</td>
        <td><span class="${info.badgeClass}">${info.label}</span></td>
        <td>${(b.paid_players || 0)}/${(b.total_players || 0)}</td>
        <td>${formatCurrency(b.total_price)}</td>
      `;
      row.addEventListener("click", () => {
        // al hacer click en una fila, cambiamos la fecha y abrimos el detalle en el panel de la derecha
        currentDateStr = b.date;
        loadBookings(currentDateStr).then(() => {
          // buscar mismo id en bookings del día y seleccionarlo
          const found = bookings.find(x => Number(x.id) === Number(b.id));
          if (found) {
            selectBooking(found.id);
            showSection("calendar");
          }
        });
      });
      bookingsTableBody.appendChild(row);
    });
  }

  // ------------------- INIT -----------------------

  function init() {
    // Recuperar sección activa desde localStorage
    let initialSection = "dashboard";
    try {
      const stored = localStorage.getItem("admin_active_section");
      if (stored) initialSection = stored;
    } catch (e) {}
    showSection(initialSection);

    // Config
    loadConfig();

    // Calendario (mes actual) + turnos de hoy
    loadCalendarMonth(calendarCurrentYear, calendarCurrentMonth);
    loadBookings(currentDateStr);

    // Horarios / precios
    if (btnSaveSchedule) btnSaveSchedule.addEventListener("click", saveSchedule);
    if (btnSavePricing) btnSavePricing.addEventListener("click", savePricing);

    // Botones estado turno
    if (btnCancelar) {
      btnCancelar.addEventListener("click", () => {
        updateBookingStatus("cancel", "cancelar");
      });
    }
    if (btnFallado) {
      btnFallado.addEventListener("click", () => {
        updateBookingStatus("mark_fallado", "marcar como fallado");
      });
    }

    if (btnToday) {
      btnToday.addEventListener("click", () => {
        const today = getTodayStr();
        currentDateStr = today;
        loadBookings(currentDateStr);
        loadCalendarMonth(calendarCurrentYear, calendarCurrentMonth);
      });
    }

    if (btnMarkAllCash) {
      btnMarkAllCash.addEventListener("click", () => {
        markAllPlayersInCurrentBooking("Efectivo");
      });
    }
    if (btnMarkAllMp) {
      btnMarkAllMp.addEventListener("click", () => {
        markAllPlayersInCurrentBooking("MP");
      });
    }
    if (btnMarkAllPaid && playersGridEl) {
      btnMarkAllPaid.addEventListener("click", () => {
        markAllPlayersInCurrentBooking(null);
        showToast("Marcados como pagados (recordá sincronizar con la caja real).");
      });
    }

    if (btnWhatsapp) {
      btnWhatsapp.addEventListener("click", () => {
        if (!currentBooking || !currentBooking.client_phone) {
          showToast("Este turno no tiene teléfono cargado.");
          return;
        }
        const phone = currentBooking.client_phone.replace(/\D/g, "");
        const dateLabel = formatDateDisplay(currentBooking.date);
        const timeLabel = formatTimeDisplay(currentBooking.time_start);
        const msg =
          "Hola " + (currentBooking.client_name || "") +
          ", te escribimos desde la cancha para confirmar tu turno del " +
          dateLabel + " a las " + timeLabel + ". ¿Confirmás asistencia?";
        const url = "https://wa.me/" + phone + "?text=" + encodeURIComponent(msg);
        window.open(url, "_blank");
      });
    }

    if (btnNotaTurno && detailNoteEl) {
      btnNotaTurno.addEventListener("click", async () => {
        if (!currentBooking || !currentBooking.id) {
          showToast("Seleccioná un turno primero.");
          return;
        }
        const note = detailNoteEl.value || "";
        try {
          const res = await fetch(`${apiBase}/bookings.php`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
              action: "save_note",
              booking_id: currentBooking.id,
              note: note
            })
          });
          const data = await res.json();
          if (!data.success) {
            showToast(data.error || "No se pudo guardar la nota.");
            return;
          }
          showToast("Nota guardada.");
          // refrescar tabla
          loadBookingsTable();
        } catch (err) {
          console.error("Error guardando nota", err);
          showToast("Error de conexión al guardar nota.");
        }
      });
    }

    // navegación de mes en calendario
    if (btnPrevMonth) {
      btnPrevMonth.addEventListener("click", () => {
        if (calendarCurrentMonth === 0) {
          calendarCurrentMonth = 11;
          calendarCurrentYear--;
        } else {
          calendarCurrentMonth--;
        }
        loadCalendarMonth(calendarCurrentYear, calendarCurrentMonth);
      });
    }
    if (btnNextMonth) {
      btnNextMonth.addEventListener("click", () => {
        if (calendarCurrentMonth === 11) {
          calendarCurrentMonth = 0;
          calendarCurrentYear++;
        } else {
          calendarCurrentMonth++;
        }
        loadCalendarMonth(calendarCurrentYear, calendarCurrentMonth);
      });
    }
    if (calendarFilterPitch) {
      calendarFilterPitch.addEventListener("change", () => {
        loadCalendarMonth(calendarCurrentYear, calendarCurrentMonth);
      });
    }

    // link desde calendario a config
    if (btnOpenSettingsFromCalendar) {
      btnOpenSettingsFromCalendar.addEventListener("click", () => {
        showSection("settings");
      });
    }

    // botones dummy clientes / reportes
    if (btnAdvancedSearch) {
      btnAdvancedSearch.addEventListener("click", () => {
        showToast("Búsqueda avanzada (conectar a /api/clients.php?action=search).");
      });
    }
    if (btnClientHistory) {
      btnClientHistory.addEventListener("click", () => {
        showToast("Historial por cliente (conectar a /api/bookings.php?action=client_history).");
      });
    }
    if (btnExportClientsExcel) {
      btnExportClientsExcel.addEventListener("click", () => {
        window.location.href = `${apiBase}/clients_export.php?format=xlsx`;
      });
    }
    if (btnExportClientsPdf) {
      btnExportClientsPdf.addEventListener("click", () => {
        window.location.href = `${apiBase}/clients_export.php?format=pdf`;
      });
    }

    if (btnReportDay) {
      btnReportDay.addEventListener("click", () => {
        showToast("Reporte económico de hoy (conectar a /api/stats.php?range=day).");
      });
    }
    if (btnReportWeek) {
      btnReportWeek.addEventListener("click", () => {
        showToast("Estadísticas de la semana (conectar a /api/stats.php?range=week).");
      });
    }
    if (btnReportMonth) {
      btnReportMonth.addEventListener("click", () => {
        showToast("Estadísticas del mes (conectar a /api/stats.php?range=month).");
      });
    }

    // Filtros tabla turnos
    setDefaultBookingsDateFilters();
    if (bookingsFilterStatus) {
      bookingsFilterStatus.addEventListener("change", loadBookingsTable);
    }
    if (bookingsFilterPitch) {
      bookingsFilterPitch.addEventListener("change", loadBookingsTable);
    }
    if (bookingsFilterDateFrom) {
      bookingsFilterDateFrom.addEventListener("change", loadBookingsTable);
    }
    if (bookingsFilterDateTo) {
      bookingsFilterDateTo.addEventListener("change", loadBookingsTable);
    }
    if (bookingsFilterSearch) {
      bookingsFilterSearch.addEventListener("input", renderBookingsTable);
    }
    if (btnBookingsExportExcel) {
      btnBookingsExportExcel.addEventListener("click", () => {
        const params = new URLSearchParams();
        params.set("format","xlsx");
        if (bookingsFilterDateFrom && bookingsFilterDateFrom.value) {
          params.set("from", bookingsFilterDateFrom.value);
        }
        if (bookingsFilterDateTo && bookingsFilterDateTo.value) {
          params.set("to", bookingsFilterDateTo.value);
        }
        window.location.href = `${apiBase}/bookings_export.php?${params.toString()}`;
      });
    }

    // Cargar tabla grande desde el inicio, así la pestaña "Turnos" siempre tiene info
    loadBookingsTable();

    // Inicializar stats visualmente
    updatePaymentStatsDisplay();
  }

  document.addEventListener("DOMContentLoaded", init);
</script>
</body>
</html>
