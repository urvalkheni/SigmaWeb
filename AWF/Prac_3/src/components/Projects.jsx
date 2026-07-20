import React, { useState, useEffect } from 'react';
import Spinner from './Spinner';
import ErrorMessage from './ErrorMessage';

const Projects = () => {
  const [repos, setRepos] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [searchQuery, setSearchQuery] = useState('');

  const fetchRepos = () => {
    setLoading(true);
    setError(null);
    fetch('https://api.github.com/users/urvalkheni/repos')
      .then((res) => {
        if (!res.ok) {
          throw new Error(`Error: ${res.status} ${res.statusText}`);
        }
        return res.json();
      })
      .then((data) => setRepos(data))
      .catch((err) => setError(err.message))
      .finally(() => setLoading(false));
  };

  useEffect(() => {
    fetchRepos();
  }, []);

  const filteredRepos = repos.filter(repo => 
    repo.name.toLowerCase().includes(searchQuery.toLowerCase())
  );

  return (
    <section className="glass-panel animate-fade-in">
      <h2 className="section-title">My Projects</h2>
      
      <div style={{ marginBottom: '2rem' }}>
        <input 
          type="text" 
          placeholder="Search repositories by name..."
          value={searchQuery}
          onChange={(e) => setSearchQuery(e.target.value)}
          style={{
            width: '100%',
            padding: '1rem',
            borderRadius: '8px',
            background: 'rgba(255,255,255,0.05)',
            border: '1px solid var(--border-color)',
            color: 'var(--text-color)',
            fontSize: '1rem'
          }}
        />
      </div>

      {loading && <Spinner />}
      
      {error && !loading && (
        <ErrorMessage message={error} onRetry={fetchRepos} />
      )}

      {!loading && !error && (
        <div className="projects-grid">
          {filteredRepos.length > 0 ? (
            filteredRepos.map((repo) => (
              <div key={repo.id} className="project-card" style={{ padding: '1.5rem', background: 'rgba(0,0,0,0.2)', borderRadius: '12px' }}>
                <h3 style={{ wordBreak: 'break-word' }}>
                  <a href={repo.html_url} target="_blank" rel="noreferrer" style={{ textDecoration: 'none' }}>
                    {repo.name}
                  </a>
                </h3>
                <p style={{ color: '#cbd5e1', marginBottom: '1rem', fontSize: '0.9rem' }}>
                  {repo.description || 'No description available.'}
                </p>
                <div style={{ display: 'flex', gap: '1rem', fontSize: '0.8rem', color: '#94a3b8' }}>
                  <span>⭐ {repo.stargazers_count}</span>
                  {repo.language && <span>{repo.language}</span>}
                </div>
              </div>
            ))
          ) : (
            <p style={{ color: '#cbd5e1' }}>No repositories found matching your search.</p>
          )}
        </div>
      )}
    </section>
  );
};

export default Projects;
