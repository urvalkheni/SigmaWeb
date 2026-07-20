import { useState, useEffect } from 'react';
import { Routes, Route } from 'react-router-dom';
import Header from './components/Header';
import NavBar from './components/NavBar';
import Home from './components/Home';
import Projects from './components/Projects';
import Contact from './components/Contact';
import NotFound from './components/NotFound';
import Footer from './components/Footer';
import './index.css';

function App() {
  const [themeMode, setThemeMode] = useState('dark');

  useEffect(() => {
    if (themeMode === 'light') {
      document.documentElement.style.setProperty('--bg-color', '#f8fafc');
      document.documentElement.style.setProperty('--text-color', '#0f172a');
      document.documentElement.style.setProperty('--card-bg', 'rgba(255, 255, 255, 0.7)');
      document.documentElement.style.setProperty('--border-color', 'rgba(0, 0, 0, 0.1)');
    } else {
      document.documentElement.style.setProperty('--bg-color', '#0f172a');
      document.documentElement.style.setProperty('--text-color', '#f8fafc');
      document.documentElement.style.setProperty('--card-bg', 'rgba(30, 41, 59, 0.7)');
      document.documentElement.style.setProperty('--border-color', 'rgba(255, 255, 255, 0.1)');
    }
  }, [themeMode]);

  const toggleTheme = () => {
    setThemeMode((prev) => (prev === 'dark' ? 'light' : 'dark'));
  };

  return (
    <>
      <div style={{ position: 'absolute', top: '1rem', right: '1rem' }}>
        <button 
          onClick={toggleTheme}
          style={{
            padding: '0.5rem 1rem',
            borderRadius: '20px',
            border: '1px solid var(--border-color)',
            background: 'var(--card-bg)',
            color: 'var(--text-color)',
            cursor: 'pointer',
            fontWeight: 'bold'
          }}
        >
          {themeMode === 'dark' ? '☀️ Light Mode' : '🌙 Dark Mode'}
        </button>
      </div>

      <Header name="Urval Kheni" themeColor="#38bdf8" />
      <NavBar />
      
      <main style={{ minHeight: '40vh' }}>
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/projects" element={<Projects />} />
          <Route path="/contact" element={<Contact />} />
          <Route path="*" element={<NotFound />} />
        </Routes>
      </main>

      <Footer />
    </>
  );
}

export default App;
