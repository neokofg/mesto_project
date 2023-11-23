import {
  PerspectiveCamera,
  Environment,
  OrbitControls,
} from "@react-three/drei";
import { Canvas } from "@react-three/fiber";

const CabinetEnv = (props: { url: string[] | undefined }) => {
  const photos = props.url;
  return <Environment files={photos} background />;
};

const SinglePanorama = (props: { url: string[] | undefined }) => {
  const {
    url = [
      "/uploads/panorama/px.jpeg",
      "/uploads/panorama/nx.jpeg",
      "/uploads/panorama/py.jpeg",
      "/uploads/panorama/ny.jpeg",
      "/uploads/panorama/pz.jpeg",
      "/uploads/panorama/nz.jpeg",
    ],
  } = props;
  return (
    <Canvas camera={{ position: [100, 1, 1] }}>
      <CabinetEnv url={url} />
      <OrbitControls enableZoom={false} makeDefault target={[0, 1, 0]} />
      <PerspectiveCamera fov={60} position={[-4, 4, 4]} makeDefault />
      <mesh
        visible
        userData={{ hello: "world" }}
        position={[-1000, -200, -800]}
        rotation={[Math.PI / 2, 0, 0]}
      >
        <sphereGeometry args={[100, 160, 160]} />
        <meshStandardMaterial color="gray" transparent />
      </mesh>
    </Canvas>
  );
};

export default SinglePanorama;
