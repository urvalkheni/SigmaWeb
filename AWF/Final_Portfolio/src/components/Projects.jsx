import React, { useState, useEffect } from 'react';
import { Code } from 'lucide-react';

const Projects = () => {
  const manualProjects = [
    {
      title: 'osint-tracker',
      tech: 'Python',
      date: 'Feb 2025',
      desc: 'Built a confidence-based OSINT CLI with cross-source correlation, improving threat prioritization by ~20%.',
    },
    {
      title: 'network-sniffer-toolkit',
      tech: 'Python',
      date: 'Nov 2025',
      desc: 'Developed a packet analysis toolkit for real-time/offline inspection, improving anomaly detection efficiency by ~30%.',
    },
    {
      title: 'Cyber_Attack_Monitoring',
      tech: 'TypeScript',
      date: 'Jan 2026',
      desc: 'Built a SOC-style monitoring system with logging, alerting, and attack visualization, reducing investigation time by ~35%.',
    }
  ];

  const [repos, setRepos] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    fetch('https://api.github.com/users/urvalkheni/repos?sort=updated&per_page=6')
      .then((res) => {
        if (!res.ok) throw new Error('Failed to fetch GitHub repos');
        return res.json();
      })
      .then((data) => setRepos(data))
      .catch((err) => setError(err.message))
      .finally(() => setLoading(false));
  }, []);

  return (
    <section id="projects" className="animate-fade-in">
      <div style={{ display: 'flex', alignItems: 'center', gap: '1rem', justifyContent: 'center', marginBottom: '2rem' }}>
        <Code size={36} color="var(--accent-color)" />
        <h2 className="section-title" style={{ margin: 0 }}>Projects</h2>
      </div>

      <h3 style={{ marginBottom: '1.5rem', color: 'var(--text-color)', textAlign: 'center' }}>Featured Work</h3>
      <div className="grid-3" style={{ marginBottom: '4rem' }}>
        {manualProjects.map((proj, idx) => (
          <div key={idx} className="card">
            <h3 style={{ fontSize: '1.3rem', marginBottom: '0.5rem', color: 'var(--accent-color)' }}>{proj.title}</h3>
            <p className="text-muted" style={{ fontSize: '0.9rem', marginBottom: '1rem' }}>
              {proj.tech} | {proj.date}
            </p>
            <p style={{ color: '#cbd5e1', fontSize: '0.95rem' }}>{proj.desc}</p>
          </div>
        ))}
      </div>

      <div style={{ display: 'flex', alignItems: 'center', gap: '0.5rem', justifyContent: 'center', marginBottom: '1.5rem' }}>
        <h3 style={{ margin: 0, color: 'var(--text-color)' }}>Latest GitHub Repositories</h3>
      </div>
      
      {loading && (
        <div style={{ textAlign: 'center', padding: '2rem' }}>
           <div className="spinner" style={{
            width: '40px', height: '40px', border: '4px solid rgba(255,255,255,0.1)', 
            borderTop: '4px solid var(--accent-color)', borderRadius: '50%', animation: 'spin 1s linear infinite', margin: '0 auto'
          }} />
        </div>
      )}

      {error && !loading && (
        <div style={{ textAlign: 'center', color: '#ef4444' }}>{error}</div>
      )}

      {!loading && !error && (
        <div className="grid-3">
          {repos.map((repo) => (
            <div key={repo.id} className="card" style={{ display: 'flex', flexDirection: 'column' }}>
              <h4 style={{ wordBreak: 'break-word', marginBottom: '0.5rem' }}>
                <a href={repo.html_url} target="_blank" rel="noreferrer">
                  {repo.name}
                </a>
              </h4>
              <p className="text-muted" style={{ fontSize: '0.9rem', flexGrow: 1, marginBottom: '1rem' }}>
                {repo.description || 'No description available.'}
              </p>
              <div style={{ display: 'flex', justifyContent: 'space-between', fontSize: '0.8rem', color: '#94a3b8' }}>
                <span>⭐ {repo.stargazers_count}</span>
                {repo.language && <span>{repo.language}</span>}
              </div>
            </div>
          ))}
        </div>
      )}
      <style>
        {`@keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }`}
      </style>
    </section>
  );
};

export default Projects;
