import { useState, useRef, useEffect } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import { createRoot } from '@wordpress/element';

import './index.scss';

function AskChokroChat() {
    const [messages, setMessages] = useState([]);
    const [input, setInput] = useState('');
    const [isLoading, setIsLoading] = useState(false);
    const messagesEndRef = useRef(null);

    // Provided via wp_localize_script
    const settings = window.askChokroSettings || { apiUrl: '', token: '' };

    const scrollToBottom = () => {
        messagesEndRef.current?.scrollIntoView({ behavior: 'smooth' });
    };

    useEffect(() => {
        scrollToBottom();
    }, [messages]);

    const handleSubmit = async (e) => {
        e.preventDefault();
        if (!input.trim() || isLoading) return;

        const userMsg = input.trim();
        setInput('');
        setMessages(prev => [...prev, { type: 'user', text: userMsg }]);
        setIsLoading(true);

        try {
            const headers = {
                'Content-Type': 'application/json',
            };
            if (settings.token) {
                headers['Authorization'] = `Bearer ${settings.token}`;
            }

            const response = await fetch(settings.apiUrl, {
                method: 'POST',
                headers,
                body: JSON.stringify({ question: userMsg })
            });

            const data = await response.json();
            
            if (!response.ok) {
                throw new Error(data.error || 'API Error');
            }

            setMessages(prev => [...prev, { 
                type: 'ai', 
                text: data.answer || 'No answer provided.',
                sql: data.sql
            }]);
        } catch (error) {
            setMessages(prev => [...prev, { 
                type: 'ai', 
                text: `Error: ${error.message}` 
            }]);
        } finally {
            setIsLoading(false);
        }
    };

    return (
        <div className="askchokro-container">
            <div className="askchokro-header">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
                AskChokro AI Assistant
            </div>
            
            <div className="askchokro-messages">
                {messages.length === 0 && (
                    <div className="askchokro-message ai">
                        Hi! I am connected to your database securely. Ask me anything about your data.
                    </div>
                )}
                {messages.map((msg, idx) => (
                    <div key={idx} className={`askchokro-message ${msg.type}`}>
                        {msg.text}
                        {msg.sql && (
                            <pre style={{ fontSize: '11px', marginTop: '8px', opacity: 0.8, overflowX: 'auto' }}>
                                {msg.sql}
                            </pre>
                        )}
                    </div>
                ))}
                {isLoading && (
                    <div className="askchokro-message ai">Thinking...</div>
                )}
                <div ref={messagesEndRef} />
            </div>

            <form className="askchokro-input-area" onSubmit={handleSubmit}>
                <input 
                    type="text" 
                    value={input} 
                    onChange={e => setInput(e.target.value)} 
                    placeholder="Ask a question..."
                    disabled={isLoading}
                />
                <button type="submit" disabled={isLoading || !input.trim()}>
                    Send
                </button>
            </form>
        </div>
    );
}

domReady(() => {
    const rootEl = document.getElementById('askchokro-root');
    if (rootEl) {
        const root = createRoot(rootEl);
        root.render(<AskChokroChat />);
    }
});
