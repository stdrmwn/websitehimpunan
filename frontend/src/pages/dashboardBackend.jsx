import React from 'react';
import Footer from '../components/Footer';
import Header from '../components/Header';
import Navbar from '../components/Navbar';
import Sidebar from '../components/Sidebar';
import SmallBox from '../components/SmallBox';

function App() {
  return (
    <div className="layout-fixed sidebar-expand-lg bg-body-tertiary">
      <div className="app-wrapper">
        <Header />
        <Navbar />
        <Sidebar />
        <main className="app-main">
          <div className="app-content-header">
            <div className="container-fluid">
              <div className="row">
                <div className="col-sm-6">
                  <h3 className="mb-0">Dashboard</h3>
                </div>
              </div>
            </div>
          </div>

          <div className="app-content">
            <div className="container-fluid">
              <div className="row">
                <SmallBox
                  color="primary"
                  value="150"
                  label="New Orders"
                  iconPath="M2.25 2.25a.75..."
                />
                <SmallBox
                  color="success"
                  value="53%"
                  label="Bounce Rate"
                  iconPath="M18.375 2.25c-1.035..."
                />
                <SmallBox
                  color="warning"
                  value="44"
                  label="User Registrations"
                  iconPath="M6.25 6.375a4.125..."
                />
                <SmallBox
                  color="danger"
                  value="65"
                  label="Unique Visitors"
                  iconPath="M2.25 13.5a8.25..."
                />
              </div>
            </div>
          </div>
        </main>
        <Footer />
      </div>
    </div>
  );
}

export default App;

