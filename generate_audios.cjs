const fs = require('fs');
const path = require('path');

const sampleRate = 44100;

function createWavBuffer(numChannels, sampleRate, samples) {
    const bytesPerSample = 2; // 16-bit PCM
    const blockAlign = numChannels * bytesPerSample;
    const byteRate = sampleRate * blockAlign;
    const dataSize = samples.length * bytesPerSample;
    const buffer = Buffer.alloc(44 + dataSize);

    // RIFF header
    buffer.write('RIFF', 0);
    buffer.writeUInt32LE(36 + dataSize, 4);
    buffer.write('WAVE', 8);

    // fmt subchunk
    buffer.write('fmt ', 12);
    buffer.writeUInt32LE(16, 16); // subchunk1 size
    buffer.writeUInt16LE(1, 20);  // PCM format
    buffer.writeUInt16LE(numChannels, 22);
    buffer.writeUInt32LE(sampleRate, 24);
    buffer.writeUInt32LE(byteRate, 28);
    buffer.writeUInt16LE(blockAlign, 32);
    buffer.writeUInt16LE(16, 34); // bits per sample

    // data subchunk
    buffer.write('data', 36);
    buffer.writeUInt32LE(dataSize, 40);

    // Write samples
    let offset = 44;
    for (let i = 0; i < samples.length; i++) {
        let s = Math.max(-1, Math.min(1, samples[i]));
        let intSample = s < 0 ? s * 0x8000 : s * 0x7FFF;
        buffer.writeInt16LE(Math.floor(intSample), offset);
        offset += 2;
    }

    return buffer;
}

// Synthesizer helper functions
function noteFreq(midiNote) {
    return 440 * Math.pow(2, (midiNote - 69) / 12);
}

function generateTrack(config) {
    const duration = config.duration || 6.0; // 6 seconds loop
    const totalSamples = Math.floor(sampleRate * duration);
    const samples = new Float32Array(totalSamples);
    const bpm = config.bpm || 120;
    const beatDuration = 60 / bpm;
    const rootNote = config.root || 60; // Middle C
    const scale = config.scale || [0, 2, 4, 5, 7, 9, 11]; // Major
    const style = config.style || 'synth';

    for (let i = 0; i < totalSamples; i++) {
        const t = i / sampleRate;
        const beatPos = (t / beatDuration);
        const currentBeat = Math.floor(beatPos);
        const beatFraction = beatPos - currentBeat;
        let val = 0;

        if (style === 'helicopter') {
            // Heavy rotor chop + engine bass + rising synth
            const rotorFreq = 14 + Math.sin(t * 0.5) * 2;
            const rotorChop = Math.pow(Math.max(0, Math.sin(2 * Math.PI * rotorFreq * t)), 3);
            const engineBass = Math.sin(2 * Math.PI * 55 * t) * 0.4;
            const sub = Math.sin(2 * Math.PI * 110 * t + Math.sin(2 * Math.PI * rotorFreq * t) * 0.5) * 0.3;
            const leadMidi = rootNote + scale[Math.floor((beatPos * 2) % scale.length)];
            const leadFreq = noteFreq(leadMidi);
            const lead = Math.sin(2 * Math.PI * leadFreq * t) * Math.exp(-beatFraction * 3) * 0.25;
            val = (engineBass + sub) * (0.3 + 0.7 * rotorChop) + lead;
        } else if (style === 'supersonic') {
            // Fast trance arp + jet sweep
            const jetSweep = (Math.sin(2 * Math.PI * 0.25 * t) * 0.5 + 0.5);
            const jetNoise = (Math.random() * 2 - 1) * 0.08 * jetSweep;
            const arpIndex = Math.floor(beatPos * 4) % scale.length;
            const arpFreq = noteFreq(rootNote + scale[arpIndex] + 12);
            const saw = ((2 * (t * arpFreq - Math.floor(t * arpFreq + 0.5)))) * 0.2 * Math.exp(-(beatFraction * 4 % 1) * 4);
            const bassFreq = noteFreq(rootNote - 12);
            const bass = Math.sin(2 * Math.PI * bassFreq * t) * 0.35;
            val = saw + bass + jetNoise;
        } else if (style === 'vintage_aero') {
            // Propeller engine drone + nostalgic chiptune
            const propDrone = Math.sin(2 * Math.PI * 75 * t) * 0.35 + ((Math.random() * 2 - 1) * 0.05);
            const melodyIndex = Math.floor(beatPos) % scale.length;
            const melodyFreq = noteFreq(rootNote + scale[melodyIndex]);
            const square = (Math.sin(2 * Math.PI * melodyFreq * t) > 0 ? 0.2 : -0.2) * Math.exp(-beatFraction * 2.5);
            val = propDrone * 0.6 + square;
        } else if (style === 'cyber') {
            // Dark synthwave pulse
            const bassNote = rootNote - 24 + scale[Math.floor(beatPos / 2) % 4];
            const bass = Math.sin(2 * Math.PI * noteFreq(bassNote) * t) * 0.4;
            const pulse = (Math.sin(2 * Math.PI * noteFreq(rootNote + 12) * t) > 0.5 ? 0.2 : -0.2) * Math.exp(-(beatFraction * 2 % 1) * 3);
            const kick = (currentBeat % 1 === 0 && beatFraction < 0.15) ? Math.sin(2 * Math.PI * (120 - beatFraction * 600) * t) * 0.5 : 0;
            val = bass + pulse + kick;
        } else if (style === 'countdown_tick') {
            // High precision sonar/radar/clock tick
            const tickRate = config.tickRate || 1.0;
            const tickPos = (t % tickRate) / tickRate;
            const freq = config.freq || 880;
            if (tickPos < 0.08) {
                const env = Math.exp(-tickPos * 45);
                val = Math.sin(2 * Math.PI * freq * t) * env * 0.7;
            }
        } else if (style === 'slot_ambient') {
            // Upbeat casino slot / bells / rhythm
            const kick = (beatFraction < 0.1 && (currentBeat % 2 === 0)) ? Math.sin(2 * Math.PI * (100 - beatFraction * 500) * t) * 0.4 : 0;
            const hat = (beatFraction > 0.45 && beatFraction < 0.55) ? (Math.random() * 2 - 1) * 0.08 : 0;
            const chordIndex = Math.floor(beatPos / 2) % 4;
            const chords = [
                [0, 4, 7],
                [5, 9, 12],
                [7, 11, 14],
                [0, 4, 7]
            ];
            let chordVal = 0;
            const chord = chords[chordIndex];
            for (let c of chord) {
                const f = noteFreq(rootNote + c);
                chordVal += Math.sin(2 * Math.PI * f * t) * 0.08;
            }
            const bellIndex = Math.floor(beatPos * 2) % scale.length;
            const bellFreq = noteFreq(rootNote + 12 + scale[bellIndex]);
            const bell = Math.sin(2 * Math.PI * bellFreq * t) * Math.exp(-(beatFraction * 2 % 1) * 4) * 0.18;
            val = kick + hat + chordVal + bell;
        } else if (style === 'lounge_card') {
            // Smooth jazz chords + subtle bass
            const chordNotes = [
                [0, 3, 7, 10], // Minor 7
                [5, 8, 12, 15],
                [7, 10, 14, 17],
                [0, 3, 7, 10]
            ];
            const ch = chordNotes[Math.floor(beatPos / 2) % chordNotes.length];
            let chordVal = 0;
            for (let n of ch) {
                const f = noteFreq(rootNote + n);
                chordVal += Math.sin(2 * Math.PI * f * t) * 0.07;
            }
            const bass = Math.sin(2 * Math.PI * noteFreq(rootNote - 24 + ch[0]) * t) * 0.3;
            val = chordVal + bass;
        } else if (style === 'lottery_bounce') {
            // Energetic melodic bells
            const noteIdx = Math.floor(beatPos * 3) % scale.length;
            const f = noteFreq(rootNote + scale[noteIdx]);
            const bell = Math.sin(2 * Math.PI * f * t) * Math.exp(-(beatFraction * 3 % 1) * 5) * 0.3;
            const bass = Math.sin(2 * Math.PI * noteFreq(rootNote - 12) * t) * 0.25;
            val = bell + bass;
        } else {
            // General melodic synth
            const noteIdx = Math.floor(beatPos * 2) % scale.length;
            const f = noteFreq(rootNote + scale[noteIdx]);
            const mel = Math.sin(2 * Math.PI * f * t) * Math.exp(-(beatFraction * 2 % 1) * 3) * 0.3;
            const sub = Math.sin(2 * Math.PI * noteFreq(rootNote - 12) * t) * 0.2;
            val = mel + sub;
        }

        samples[i] = Math.max(-0.95, Math.min(0.95, val));
    }

    return createWavBuffer(1, sampleRate, samples);
}

const targetDir = path.join(__dirname, 'public', 'assets', 'audio', 'games');
if (!fs.existsSync(targetDir)) {
    fs.mkdirSync(targetDir, { recursive: true });
}

// 1. Crash Games BG Music (5 distinct tracks)
const crashConfigs = {
    'helicopterx_bg.mp3': { style: 'helicopter', bpm: 135, root: 57, duration: 8.0, scale: [0, 3, 5, 7, 10] },
    '1xaero_bg.mp3':       { style: 'supersonic', bpm: 140, root: 60, duration: 8.0, scale: [0, 2, 4, 7, 9, 12] },
    'aero_bg.mp3':         { style: 'vintage_aero', bpm: 125, root: 62, duration: 8.0, scale: [0, 4, 7, 9, 11] },
    'crashx_bg.mp3':       { style: 'cyber', bpm: 130, root: 55, duration: 8.0, scale: [0, 2, 3, 7, 8, 10] },
    'crash_bg.mp3':        { style: 'cyber', bpm: 145, root: 58, duration: 8.0, scale: [0, 3, 6, 7, 10] }
};

// 2. Crash Games Countdown Ticks (5 distinct tick sound effects)
const tickConfigs = {
    'countdown_helicopterx.mp3': { style: 'countdown_tick', freq: 1050, tickRate: 0.5, duration: 2.0 },
    'countdown_1xaero.mp3':       { style: 'countdown_tick', freq: 1320, tickRate: 0.5, duration: 2.0 },
    'countdown_aero.mp3':         { style: 'countdown_tick', freq: 780,  tickRate: 0.5, duration: 2.0 },
    'countdown_crashx.mp3':       { style: 'countdown_tick', freq: 1200, tickRate: 0.5, duration: 2.0 },
    'countdown_crash.mp3':        { style: 'countdown_tick', freq: 920,  tickRate: 0.5, duration: 2.0 }
};

// 3. All 30+ Games on the site (Unique dedicated tracks for each game)
const gameConfigs = {
    'olympus_bg.mp3':          { style: 'slot_ambient', bpm: 128, root: 60, duration: 8.0, scale: [0, 2, 4, 7, 9] },
    'western_vault_bg.mp3':    { style: 'slot_ambient', bpm: 115, root: 62, duration: 8.0, scale: [0, 2, 4, 7, 9] },
    'boxing_king_bg.mp3':      { style: 'cyber', bpm: 132, root: 57, duration: 8.0, scale: [0, 3, 5, 7, 10] },
    'fortune_gems_2_bg.mp3':   { style: 'slot_ambient', bpm: 122, root: 65, duration: 8.0, scale: [0, 2, 5, 7, 9] },
    'abyss_of_glory_bg.mp3':   { style: 'cyber', bpm: 118, root: 53, duration: 8.0, scale: [0, 2, 3, 7, 8] },
    'heads_or_tails_bg.mp3':   { style: 'lounge_card', bpm: 110, root: 60, duration: 8.0, scale: [0, 3, 5, 7, 10] },
    'under_and_over_7_bg.mp3': { style: 'lounge_card', bpm: 116, root: 64, duration: 8.0, scale: [0, 2, 4, 7, 9] },
    'lucky_joker_100_bg.mp3':  { style: 'slot_ambient', bpm: 130, root: 67, duration: 8.0, scale: [0, 4, 7, 11] },
    'bonbon_bonanza_bg.mp3':   { style: 'lottery_bounce', bpm: 126, root: 69, duration: 8.0, scale: [0, 2, 4, 7, 9] },
    'big_bass_splash_bg.mp3':  { style: 'slot_ambient', bpm: 120, root: 62, duration: 8.0, scale: [0, 2, 4, 7, 9] },
    'the_emirate_bg.mp3':      { style: 'slot_ambient', bpm: 112, root: 58, duration: 8.0, scale: [0, 1, 4, 5, 7, 8, 11] },
    'royal_emirates_bg.mp3':   { style: 'slot_ambient', bpm: 114, root: 58, duration: 8.0, scale: [0, 2, 4, 7, 9] },
    'indian_poker_bg.mp3':     { style: 'lounge_card', bpm: 115, root: 62, duration: 8.0, scale: [0, 1, 4, 5, 7, 8, 10] },
    'card_games_21_bg.mp3':    { style: 'lounge_card', bpm: 105, root: 57, duration: 8.0, scale: [0, 3, 7, 10] },
    'roman_slot_bg.mp3':       { style: 'slot_ambient', bpm: 125, root: 60, duration: 8.0, scale: [0, 3, 5, 7, 10] },
    'easter_slot_bg.mp3':      { style: 'lottery_bounce', bpm: 130, root: 65, duration: 8.0, scale: [0, 2, 4, 5, 7, 9] },
    'juice_slots_bg.mp3':      { style: 'lottery_bounce', bpm: 128, root: 67, duration: 8.0, scale: [0, 4, 7, 9] },
    'crystal_bg.mp3':          { style: 'lottery_bounce', bpm: 120, root: 72, duration: 8.0, scale: [0, 4, 7, 11] },
    'burning_hot_bg.mp3':      { style: 'slot_ambient', bpm: 134, root: 58, duration: 8.0, scale: [0, 3, 5, 7, 10] },
    'wingo_bg.mp3':            { style: 'lottery_bounce', bpm: 128, root: 64, duration: 8.0, scale: [0, 2, 4, 7, 9] },
    'k3_bg.mp3':               { style: 'lottery_bounce', bpm: 135, root: 67, duration: 8.0, scale: [0, 2, 5, 7, 9] },
    'trxwingo_bg.mp3':         { style: 'cyber', bpm: 138, root: 60, duration: 8.0, scale: [0, 3, 5, 7, 10] },
    'super_ace_deluxe_bg.mp3': { style: 'slot_ambient', bpm: 126, root: 65, duration: 8.0, scale: [0, 4, 7, 9, 11] },
    'mega_ace_bg.mp3':         { style: 'cyber', bpm: 130, root: 62, duration: 8.0, scale: [0, 2, 5, 7, 10] },
    'ali_baba_bg.mp3':         { style: 'slot_ambient', bpm: 116, root: 58, duration: 8.0, scale: [0, 1, 4, 5, 7, 8, 11] },
    'golden_empire_bg.mp3':    { style: 'slot_ambient', bpm: 124, root: 60, duration: 8.0, scale: [0, 2, 5, 7, 9] },
    'fortune_gems_bg.mp3':     { style: 'lottery_bounce', bpm: 122, root: 64, duration: 8.0, scale: [0, 4, 7, 11] },
    'temple_of_fortune_bg.mp3':{ style: 'slot_ambient', bpm: 118, root: 62, duration: 8.0, scale: [0, 3, 5, 7, 10] },
    'treasure_climb_bg.mp3':   { style: 'slot_ambient', bpm: 125, root: 65, duration: 8.0, scale: [0, 2, 4, 7, 9] },
    'gems_mines_bg.mp3':       { style: 'lounge_card', bpm: 112, root: 55, duration: 8.0, scale: [0, 3, 7, 10] },
    'elves_kingdom_bg.mp3':    { style: 'lottery_bounce', bpm: 115, root: 70, duration: 8.0, scale: [0, 2, 4, 7, 9, 11] },
    'casino_ambient.mp3':      { style: 'lounge_card', bpm: 108, root: 60, duration: 8.0, scale: [0, 4, 7, 9] },
    'slot_bg.mp3':             { style: 'slot_ambient', bpm: 125, root: 60, duration: 8.0, scale: [0, 2, 4, 7, 9] },
    'card_bg.mp3':             { style: 'lounge_card', bpm: 110, root: 57, duration: 8.0, scale: [0, 3, 7, 10] },
    'lottery_bg.mp3':          { style: 'lottery_bounce', bpm: 130, root: 64, duration: 8.0, scale: [0, 2, 4, 7, 9] }
};

const allFiles = { ...crashConfigs, ...tickConfigs, ...gameConfigs };

console.log(`Generating ${Object.keys(allFiles).length} unique game audio files...`);

for (const [filename, conf] of Object.entries(allFiles)) {
    const buffer = generateTrack(conf);
    const filePath = path.join(targetDir, filename);
    fs.writeFileSync(filePath, buffer);
    console.log(`Generated: ${filename} (${buffer.length} bytes)`);
}

console.log('All game audio files generated successfully!');
